<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'buyer_name',
        'buyer_email',
        'buyer_phone',
        'buyer_address',
        'property_id',
        'reference',
        'amount',
        'type',
        'schedule',
        'installment_number',
        'total_installments',
        'proof_file',
        'status',
        'admin_notes',
        'approved_at',
        'approved_by',
        'sale_date',
        'payment_method',
        'staff_notes',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'approved_at' => 'datetime',
            'sale_date' => 'datetime',
        ];
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function receipt()
    {
        return $this->hasOne(Receipt::class);
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    // Helper Methods
    public function getFormattedAmountAttribute()
    {
        return '₦' . number_format($this->amount, 2);
    }

    public function getBuyerNameAttribute()
    {
        return $this->user ? $this->user->name : $this->attributes['buyer_name'] ?? 'Walk-in Customer';
    }

    public function getBuyerEmailAttribute()
    {
        return $this->user ? $this->user->email : $this->attributes['buyer_email'] ?? null;
    }

    public function getBuyerPhoneAttribute()
    {
        return $this->user ? $this->user->phone : $this->attributes['buyer_phone'] ?? null;
    }

    public function getBuyerAddressAttribute()
    {
        if ($this->user && $this->user->address) {
            return $this->user->address;
        }
        return $this->attributes['buyer_address'] ?? null;
    }

    public static function generateReference()
    {
        return 'PAY-' . strtoupper(uniqid());
    }
}
