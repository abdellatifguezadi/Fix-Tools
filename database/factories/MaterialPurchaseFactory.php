<?php

namespace Database\Factories;

use App\Models\MaterialPurchase;
use App\Models\User;
use App\Models\Material;
use Illuminate\Database\Eloquent\Factories\Factory;

class MaterialPurchaseFactory extends Factory
{
    protected $model = MaterialPurchase::class;

    public function definition()
    {
        $material = Material::inRandomOrder()->first();
        if (!$material) {
            $material = Material::factory()->create();
        }
        
        $quantity = $this->faker->numberBetween(1, 5);
        $pricePaid = $material->price * $quantity;
 
        $usePoints = $this->faker->boolean(30); 
        $pointsUsed = $usePoints ? $this->faker->numberBetween(5, min(50, $material->points_cost * $quantity)) : null;
        
        $paymentMethods = ['credit_card', 'debit_card', 'paypal', 'bank_transfer', 'points'];
        $status = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];
        
        return [
            'professional_id' => User::where('role', 'professional')->inRandomOrder()->first()->id ?? User::factory()->create(['role' => 'professional']),
            'material_id' => $material->id,
            'quantity' => $quantity,
            'price_paid' => $pricePaid,
            'points_used' => $pointsUsed,
            'payment_method' => $pointsUsed > 0 ? 'points' : $this->faker->randomElement($paymentMethods),
            'status' => $this->faker->randomElement($status),
        ];
    }

    public function usingOnlyPoints()
    {
        return $this->state(function (array $attributes) {
            $material = Material::find($attributes['material_id']);
            $quantity = $attributes['quantity'];
            
            return [
                'price_paid' => 0,
                'points_used' => $material->points_cost * $quantity,
                'payment_method' => 'points',
            ];
        });
    }
    
    public function delivered()
    {
        return $this->state(function () {
            return [
                'status' => 'delivered',
            ];
        });
    }
} 