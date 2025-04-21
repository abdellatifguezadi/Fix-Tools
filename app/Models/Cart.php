<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'professional_id',
        'is_active',
    ];

    /**
     * Récupère le professionnel propriétaire du panier
     */
    public function professional()
    {
        return $this->belongsTo(User::class, 'professional_id');
    }

    /**
     * Récupère les éléments du panier
     */
    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * Récupère le panier actif d'un professionnel ou en crée un nouveau
     */
    public static function getOrCreateCart($professionalId)
    {
        $cart = self::where('professional_id', $professionalId)
                    ->where('is_active', true)
                    ->first();

        if (!$cart) {
            $cart = self::create([
                'professional_id' => $professionalId,
                'is_active' => true
            ]);
        }

        return $cart;
    }

    /**
     * Calcule le total du panier
     */
    public function getTotal()
    {
        $total = 0;
        foreach ($this->items as $item) {
            $total += $item->material->price * $item->quantity;
        }
        return $total;
    }

    /**
     * Calcule le nombre total d'articles dans le panier
     */
    public function getTotalItems()
    {
        return $this->items->sum('quantity');
    }
} 