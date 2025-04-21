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

    /**
     * Récupère le panier auquel cet élément appartient
     */
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    /**
     * Récupère le matériel associé à cet élément
     */
    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    /**
     * Calcule le sous-total pour cet élément
     */
    public function getSubtotal()
    {
        return $this->material->price * $this->quantity;
    }

    /**
     * Calcule les points qui seraient nécessaires pour acheter cet élément avec des points
     */
    public function getPointsCost()
    {
        return $this->material->points_cost * $this->quantity;
    }
} 