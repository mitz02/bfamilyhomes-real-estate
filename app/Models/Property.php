<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
class Property extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'agent_id',
        'title',
        'description',
        'type',
        'category',
        'price',
        'roi_percentage',
        'investment_duration',
        'location',
        'address',
        'latitude',
        'longitude',
        'bedrooms',
        'bathrooms',
        'parking',
        'size',
        'features',
        'images',
        'video_url',
        'status',
        'approval_status',
        'is_featured',
        'tags',
        'rejection_reason',
        'views',
        'sold_info',
        'sold_at',
    ];

    protected function casts(): array
    {
        return [
            'features' => 'array',
            'images' => 'array',
            'tags' => 'array',
            'is_featured' => 'boolean',
            'price' => 'decimal:2',
            'latitude' => 'decimal:8',
            'longitude' => 'decimal:8',
            'sold_at' => 'datetime',
        ];
    }

    // Relationships
    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function inspections()
    {
        return $this->hasMany(Inspection::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function investments()
    {
        return $this->hasMany(Investment::class);
    }

    // Scopes
    public function scopeApproved($query)
    {
        return $query->where('approval_status', 'approved');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeAvailable($query)
    {
        return $query->where(function($q) {
            $q->where('status', 'Available')
              ->orWhere('status', 'Sold')
              ->orWhereNull('status');
        });
    }

    public function scopeForRent($query)
    {
        return $query->where('type', 'Rent');
    }

    public function scopeForSale($query)
    {
        return $query->where('type', 'Sale');
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('location', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%");
        });
    }

    // Helper Methods
    public function incrementViews()
    {
        $this->increment('views');
    }

  public function getFirstImageAttribute()
{
    $images = $this->images;

    // Handle case where images is a JSON string instead of array (double-encoded)
    if (is_string($images)) {
        $decoded = json_decode($images, true);
        $images = is_array($decoded) ? $decoded : null;
    }

    // Return default image if no images exist
    if (empty($images) || !is_array($images)) {
        return 'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=800';
    }

    $firstImage = $images[0];

    // Return as-is if already a full URL or starts with '/'
    if (is_string($firstImage) && (Str::startsWith($firstImage, ['http', '/']))) {
        return $firstImage;
    }

    // Otherwise, assume it's a storage path
    $path = ltrim($firstImage, '/');
    $url = asset('storage/' . $path);

    // Check if file actually exists in storage, fall back to placeholder if not
    if (!Storage::disk('public')->exists($path)) {
        return 'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=800';
    }

    return $url;
}

    public function getFormattedPriceAttribute()
    {
        return '₦' . number_format($this->price, 2);
    }

    /**
     * Get user's payment for this property
     */
    public function getUserPayment($userId = null)
    {
        if (!$userId && auth()->check()) {
            $userId = auth()->id();
        }
        
        if (!$userId) {
            return null;
        }

        return $this->payments()
            ->where('user_id', $userId)
            ->latest()
            ->first();
    }

    /**
     * Check if user has pending payment
     */
    public function hasPendingPayment($userId = null)
    {
        $payment = $this->getUserPayment($userId);
        return $payment && $payment->status === 'pending';
    }

    /**
     * Get payment type based on property type
     */
    public function getPaymentType()
    {
        return match($this->type) {
            'Sale' => 'purchase',
            'Rent' => 'rent',
            'Investment' => 'investment',
            default => 'purchase',
        };
    }

    public function isSold()
    {
        return $this->status === 'Sold';
    }

    public function getSoldBadgeText()
    {
        if (!$this->isSold()) {
            return null;
        }
        return $this->sold_info ?: 'Sold Out';
    }
}
