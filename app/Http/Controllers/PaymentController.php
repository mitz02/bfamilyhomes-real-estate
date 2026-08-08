<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Property;
use App\Models\Notification;
use App\Models\Setting;
use App\Models\User;
use App\Support\AdminNotifier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    public static function bankDetails(): array
    {
        return [
            'name' => Setting::get('bank_name', config('bfamily.bank.name')),
            'account_number' => Setting::get('bank_account_number', config('bfamily.bank.account_number')),
            'account_name' => Setting::get('bank_account_name', config('bfamily.bank.account_name')),
        ];
    }

    public function index()
    {
        $payments = Payment::where('user_id', auth()->id())
            ->with('property')
            ->latest()
            ->paginate(10);

        $bankDetails = self::bankDetails();

        return view('dashboard.payments.index', compact('payments', 'bankDetails'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'property_id' => 'required|exists:properties,id',
                'amount' => 'nullable|numeric|min:0',
                'type' => 'nullable|in:purchase,rent,investment,installment',
                'schedule' => 'nullable|in:One-time,Monthly,Quarterly,Annually',
                'installment_number' => 'nullable|integer',
                'total_installments' => 'nullable|integer',
            ]);

            $property = Property::findOrFail($validated['property_id']);

            // Check if payment already exists for this property and user
            $existingPayment = Payment::where('user_id', auth()->id())
                ->where('property_id', $validated['property_id'])
                ->where('status', 'pending')
                ->first();

            if ($existingPayment) {
                return response()->json([
                    'success' => true,
                    'message' => 'Payment already exists',
                    'payment' => $existingPayment,
                    'redirect' => route('payments.instructions', $existingPayment->id),
                ]);
            }

            // Auto-determine payment type from property type if not provided
            $paymentType = $validated['type'] ?? $property->getPaymentType();
            
            // Use property price if amount not provided
            $amount = $validated['amount'] ?? $property->price;

            $payment = Payment::create([
                'user_id' => auth()->id(),
                'property_id' => $validated['property_id'],
                'reference' => Payment::generateReference(),
                'amount' => $amount,
                'type' => $paymentType,
                'schedule' => $validated['schedule'] ?? 'One-time',
                'installment_number' => $validated['installment_number'] ?? null,
                'total_installments' => $validated['total_installments'] ?? null,
                'status' => 'pending',
            ]);

            AdminNotifier::notify(
                'payment_initiated',
                'New ' . ucfirst($paymentType) . ' Initiated',
                auth()->user()->name . ' initiated a <strong>' . $paymentType . '</strong> of ' . $payment->formatted_amount . ' for <strong>' . ($property->title ?? 'a property') . '</strong>.',
                [
                    'Customer' => auth()->user()->name,
                    'Email' => auth()->user()->email,
                    'Reference' => $payment->reference,
                    'Amount' => $payment->formatted_amount,
                    'Property' => $property->title ?? 'N/A',
                    'Payment Type' => ucfirst($paymentType),
                    'Schedule' => $payment->schedule,
                ],
                route('admin.payments'),
                'View Payment'
            );

            return response()->json([
                'success' => true,
                'message' => 'Payment reference generated successfully',
                'payment' => $payment,
                'redirect' => route('payments.instructions', $payment->id),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to initiate payment: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function instructions($id)
    {
        $payment = Payment::where('user_id', auth()->id())
            ->with('property')
            ->findOrFail($id);

        $bankDetails = self::bankDetails();

        return view('dashboard.payments.instructions', compact('payment', 'bankDetails'));
    }

    public function uploadProof(Request $request)
    {
        try {
            $validated = $request->validate([
                'payment_id' => 'required|exists:payments,id',
                'proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
            ]);

            $payment = Payment::where('user_id', auth()->id())
                ->findOrFail($validated['payment_id']);

            // Delete old proof if exists
            if ($payment->proof_file) {
                Storage::delete($payment->proof_file);
            }

            $path = $request->file('proof')->store('payment-proofs', 'public');
            $payment->update(['proof_file' => $path]);

            // Notify admin
            $admin = User::where('role', 'admin')->first();
            if ($admin) {
                Notification::createNotification(
                    $admin->id,
                    'payment_received',
                    'New Payment Proof',
                    auth()->user()->name . " uploaded payment proof for ₦" . number_format($payment->amount, 2),
                    $payment,
                    'bi-credit-card',
                    'info'
                );
            }

            AdminNotifier::notify(
                'payment_received',
                'Payment Proof Uploaded',
                auth()->user()->name . ' uploaded payment proof for <strong>' . $payment->formatted_amount . '</strong>. A receipt is now awaiting your review and approval.',
                [
                    'Customer' => auth()->user()->name,
                    'Email' => auth()->user()->email,
                    'Reference' => $payment->reference,
                    'Amount' => $payment->formatted_amount,
                    'Property' => $payment->property->title ?? 'N/A',
                    'Payment Type' => ucfirst($payment->type),
                ],
                route('admin.payments'),
                'Review Payment'
            );

            return response()->json([
                'success' => true,
                'message' => 'Payment proof uploaded successfully! Awaiting admin approval.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to upload proof',
            ], 500);
        }
    }
}
