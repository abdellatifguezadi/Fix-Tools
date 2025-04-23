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


    public function professional()
    {
        return $this->belongsTo(User::class, 'professional_id');
    }


    public function items()
    {
        return $this->hasMany(CartItem::class);
    }


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


    public function getTotal()
    {
        $total = 0;
        foreach ($this->items as $item) {
            $total += $item->material->price * $item->quantity;
        }
        return $total;
    }


    public function getTotalItems()
    {
        return $this->items->sum('quantity');
    }
} 