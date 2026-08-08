<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role',
        'status',
        'avatar',
        'address',
        'verification_token',
        'investor_requested_at',
        'investor_approved_at',
        'agent_requested_at',
        'agent_approved_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'verification_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'investor_requested_at' => 'datetime',
            'investor_approved_at' => 'datetime',
            'agent_requested_at' => 'datetime',
            'agent_approved_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relationships
    public function properties()
    {
        return $this->hasMany(Property::class, 'agent_id');
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
        return $this->hasMany(Investment::class, 'investor_id');
    }

    public function testimonials()
    {
        return $this->hasMany(Testimonial::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function unreadNotifications()
    {
        return $this->notifications()->unread();
    }

    public function wishlist()
    {
        // Many-to-many relationship with Property through wishlists table
        // Returns empty collection if table doesn't exist (handled by Laravel)
        return $this->belongsToMany(Property::class, 'wishlists', 'user_id', 'property_id')
            ->withTimestamps();
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeAgents($query)
    {
        return $query->where('role', 'agent');
    }

    public function scopeInvestors($query)
    {
        return $query->where('role', 'investor');
    }

    // Helper Methods
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isAgent()
    {
        return $this->role === 'agent';
    }

    public function isInvestor()
    {
        return $this->role === 'investor';
    }

    public function isBlocked()
    {
        return $this->status === 'blocked';
    }
}
