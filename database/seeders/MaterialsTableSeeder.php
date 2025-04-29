<?php

namespace Database\Seeders;

use App\Models\Material;
use App\Models\Category;
use Illuminate\Database\Seeder;

class MaterialsTableSeeder extends Seeder
{
    
    public function run(): void
    {
        $materialCategoriesCount = Category::where('type', 'material')->count();
        
        if ($materialCategoriesCount === 0) {
            Category::create(['name' => 'Outils à main', 'type' => 'material']);
            Category::create(['name' => 'Outils électriques', 'type' => 'material']);
            Category::create(['name' => 'Sécurité', 'type' => 'material']);
            Category::create(['name' => 'Mesure et marquage', 'type' => 'material']);
            Category::create(['name' => 'Accessoires', 'type' => 'material']);
        }
        
        Material::factory(20)->create();
    }
}
