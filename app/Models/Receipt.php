<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_id',
        'receipt_number',
        'file_path',
        'generated_by',
        'generated_at',
    ];

    protected function casts(): array
    {
        return [
            'generated_at' => 'datetime',
        ];
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function generator()
    {
        return $this->belongsTo(User::class, 'generated_by');
    }

    public static function generateReceiptNumber(): string
    {
        $year = now()->format('Y');
        $last = self::whereYear('created_at', $year)->latest()->first();
        $seq = $last ? intval(substr($last->receipt_number, -5)) + 1 : 1;
        return 'RCP-' . $year . '-' . str_pad($seq, 5, '0', STR_PAD_LEFT);
    }
}
