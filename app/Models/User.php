<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'image',
        'phone',
        'address',
        'city',
        'role',
        'description',
        'profession_category_id',
        'is_available',
        'total_points'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $dates = ['deleted_at'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_available' => 'boolean',
            'total_points' => 'integer',
            'deleted_at' => 'datetime',
        ];
    }

    public function professionCategory()
    {
        return $this->belongsTo(Category::class, 'profession_category_id');
    }

    public function services()
    {
        return $this->hasMany(Service::class, 'professional_id');
    }

    public function requestedServices()
    {
        return $this->hasMany(ServiceRequest::class, 'client_id');
    }

    public function providedServices()
    {
        return $this->hasMany(ServiceRequest::class, 'professional_id');
    }

    public function serviceRequests()
    {
        if ($this->role === 'client') {
            return $this->requestedServices();
        } elseif ($this->role === 'professional') {
            return $this->providedServices();
        }
        
        return $this->requestedServices(); 
    }

    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    public function givenReviews()
    {
        return $this->hasMany(Review::class, 'client_id');
    }

    public function receivedReviews()
    {
        return $this->hasMany(Review::class, 'professional_id');
    }

    public function loyaltyPoints()
    {
        return $this->hasMany(LoyaltyPoint::class, 'professional_id');
    }

    public function materialPurchases()
    {
        return $this->hasMany(MaterialPurchase::class, 'professional_id');
    }

    public function cart()
    {
        return $this->hasOne(Cart::class, 'professional_id');
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isProfessional()
    {
        return $this->role === 'professional';
    }

    public function isClient()
    {
        return $this->role === 'client';
    }
}
