<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'material_id',
        'quantity',
    ];


    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }


    public function material()
    {
        return $this->belongsTo(Material::class);
    }


    public function getSubtotal()
    {
        return $this->material->price * $this->quantity;
    }


    public function getPointsCost()
    {
        return $this->material->points_cost * $this->quantity;
    }
} 