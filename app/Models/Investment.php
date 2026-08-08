<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Investment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'investor_id',
        'property_id',
        'payment_id',
        'reference',
        'amount',
        'roi_percentage',
        'total_return',
        'duration_months',
        'start_date',
        'maturity_date',
        'status',
        'terms',
        'withdrawal_requested_at',
        'withdrawal_status',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'roi_percentage' => 'decimal:2',
            'total_return' => 'decimal:2',
            'start_date' => 'date',
            'maturity_date' => 'date',
            'withdrawal_requested_at' => 'datetime',
        ];
    }

    // Relationships
    public function investor()
    {
        return $this->belongsTo(User::class, 'investor_id');
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeMatured($query)
    {
        return $query->where('maturity_date', '<=', now())
                     ->where('status', 'active');
    }

    // Helper Methods
    public function getFormattedAmountAttribute()
    {
        return '₦' . number_format($this->amount, 2);
    }

    public static function generateReference()
    {
        return 'INV-' . strtoupper(uniqid());
    }
}
