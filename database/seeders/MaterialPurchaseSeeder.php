<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MaterialPurchase;
use App\Models\User;
use App\Models\Material;

class MaterialPurchaseSeeder extends Seeder
{
    
    public function run(): void
    {
        $professionals = User::where('role', 'professional')->get();
        
        if (Material::count() === 0) {
            Material::factory()->count(10)->create();
        }
        
        foreach ($professionals as $professional) {
            $purchaseCount = rand(1, 5);
            
            for ($i = 0; $i < $purchaseCount; $i++) {
                $material = Material::inRandomOrder()->first();
                $quantity = rand(1, 3);
                
                $usePoints = (rand(1, 100) <= 30);
                
                if ($usePoints) {
                    MaterialPurchase::factory()->usingOnlyPoints()->create([
                        'professional_id' => $professional->id,
                        'material_id' => $material->id,
                        'quantity' => $quantity,
                    ]);
                } else {
                    $pricePaid = $material->price * $quantity;
                    
                    MaterialPurchase::factory()->create([
                        'professional_id' => $professional->id,
                        'material_id' => $material->id,
                        'quantity' => $quantity,
                        'price_paid' => $pricePaid,
                        'points_used' => null,
                        'payment_method' => $this->getRandomPaymentMethod(),
                    ]);
                }
            }
        }
        
        MaterialPurchase::factory()->count(10)->create();
        
        $purchasesToMakeDelivered = MaterialPurchase::inRandomOrder()->limit(15)->get();
        foreach ($purchasesToMakeDelivered as $purchase) {
            $purchase->update(['status' => 'delivered']);
        }
    }
    

    private function getRandomPaymentMethod(): string
    {
        $methods = ['credit_card', 'debit_card', 'paypal', 'bank_transfer'];
        return $methods[array_rand($methods)];
    }
} 