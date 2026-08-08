<?php

namespace App\Support;

use App\Mail\AdminNotificationMail;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AdminNotifier
{
    public static function notify(
        string $type,
        string $title,
        string $message,
        array $details = [],
        ?string $actionUrl = null,
        ?string $actionText = null,
    ): void {
        $admins = User::where('role', 'admin')->get();

        if ($admins->isEmpty()) {
            Log::warning('AdminNotifier: no admin users found', ['type' => $type]);
            return;
        }

        foreach ($admins as $admin) {
            try {
                Mail::to($admin->email)->send(
                    new AdminNotificationMail($type, $title, $message, $details, $actionUrl, $actionText)
                );
            } catch (\Exception $e) {
                Log::warning('AdminNotifier: failed to email admin', [
                    'type' => $type,
                    'admin_id' => $admin->id,
                    'admin_email' => $admin->email,
                    'error' => $e->getMessage(),
                ]);
            }
        }
    }
}
