<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Material;
use App\Models\Category;

class MaterialSeeder extends Seeder
{

    public function run(): void
    {
        $categories = [
            'Tools' => 'tools',
            'Power Tools' => 'power_tools',
            'Measurement' => 'measurement',
            'Safety' => 'safety',
            'Painting' => 'painting',
            'Fasteners' => 'fasteners',
            'Storage' => 'storage',
        ];
        
        foreach ($categories as $name => $type) {
            Category::firstOrCreate(['name' => $name], ['type' => $type]);
        }
        
        $predefinedMaterials = [
            [
                'name' => 'Professional Hammer',
                'description' => 'High-quality steel hammer with ergonomic grip',
                'category_id' => Category::where('name', 'Tools')->first()->id,
                'price' => 149.99,
                'points_cost' => 15,
                'stock_quantity' => 25,
                'image_path' => 'materials/hammer.jpg',
                'is_available' => true,
            ],
            [
                'name' => 'Screwdriver Set',
                'description' => 'Complete set of Phillips and flathead screwdrivers',
                'category_id' => Category::where('name', 'Tools')->first()->id,
                'price' => 179.99,
                'points_cost' => 18,
                'stock_quantity' => 20,
                'image_path' => 'materials/screwdriver_set.jpg',
                'is_available' => true,
            ],
            
            [
                'name' => 'Cordless Drill',
                'description' => '18V cordless drill with battery and charger',
                'category_id' => Category::where('name', 'Power Tools')->first()->id,
                'price' => 399.99,
                'points_cost' => 40,
                'stock_quantity' => 15,
                'image_path' => 'materials/cordless_drill.jpg',
                'is_available' => true,
            ],
            
            [
                'name' => 'Safety Glasses',
                'description' => 'Impact-resistant safety glasses',
                'category_id' => Category::where('name', 'Safety')->first()->id,
                'price' => 59.99,
                'points_cost' => 6,
                'stock_quantity' => 50,
                'image_path' => 'materials/safety_glasses.jpg',
                'is_available' => true,
            ],
        ];
        
        foreach ($predefinedMaterials as $material) {
            Material::firstOrCreate(
                ['name' => $material['name']],
                $material
            );
        }
        
        Material::factory()->count(20)->create();
    }
} 