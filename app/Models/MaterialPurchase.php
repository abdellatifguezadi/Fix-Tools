<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MaterialPurchase extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'professional_id',
        'material_id',
        'quantity',
        'price_paid',
        'points_used',
        'payment_method',
        'status'
    ];

    protected $casts = [
        'quantity' => 'integer',
        'price_paid' => 'decimal:2',
        'points_used' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    // Relations
    public function professional()
    {
        return $this->belongsTo(User::class, 'professional_id');
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    // Accesseurs
    public function getTotalAmountAttribute()
    {
        return $this->quantity * $this->price_paid;
    }
}
