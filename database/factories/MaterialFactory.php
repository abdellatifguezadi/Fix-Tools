<?php

namespace Database\Factories;

use App\Models\Material;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class MaterialFactory extends Factory
{
    protected $model = Material::class;

    public function definition()
    {
        $materials = [
            'Hammer' => ['Tool for driving nails', 'tools', 150],
            'Screwdriver Set' => ['Set of various screwdrivers', 'tools', 200],
            'Wrench Set' => ['Various sizes of wrenches', 'tools', 250],
            'Drill' => ['Power drill for various materials', 'power_tools', 400],
            'Saw' => ['Manual or electric saw', 'power_tools', 350],
            'Measuring Tape' => ['Retractable measuring tape', 'measurement', 80],
            'Level Tool' => ['Spirit level for accurate alignments', 'measurement', 120],
            'Pliers' => ['Gripping and cutting tool', 'tools', 100],
            'Paint Brush Set' => ['Various sizes of paint brushes', 'painting', 180],
            'Paint Roller Kit' => ['Roller and tray for painting', 'painting', 220],
            'Safety Goggles' => ['Protection for eyes', 'safety', 60],
            'Work Gloves' => ['Protection for hands', 'safety', 70],
            'Ladder' => ['Portable steps for height access', 'access', 500],
            'Toolbox' => ['Storage for various tools', 'storage', 350],
            'Nails Assortment' => ['Various sizes of nails', 'fasteners', 120],
            'Screws Assortment' => ['Various sizes of screws', 'fasteners', 130],
        ];
        
        $material = $this->faker->randomElement(array_keys($materials));
        $info = $materials[$material];
        
        $category = Category::firstOrCreate(
            ['name' => ucfirst($info[1])],
            ['type' => $info[1]]
        );
        
        return [
            'name' => $material,
            'description' => $info[0],
            'category_id' => $category->id,
            'price' => $this->faker->randomFloat(2, 20, $info[2]),
            'points_cost' => intval($info[2] / 10), 
            'stock_quantity' => $this->faker->numberBetween(5, 50),
            'image_path' => 'materials/' . str_replace(' ', '_', strtolower($material)) . '.jpg',
            'is_available' => $this->faker->boolean(90), 
        ];
    }
    

    public function tools()
    {
        return $this->state(function () {
            $toolCategory = Category::where('name', 'Tools')->first();
            if (!$toolCategory) {
                $toolCategory = Category::create(['name' => 'Tools', 'type' => 'tools']);
            }
            
            return [
                'category_id' => $toolCategory->id,
            ];
        });
    }
    

    public function lowStock()
    {
        return $this->state(function () {
            return [
                'stock_quantity' => $this->faker->numberBetween(0, 5),
            ];
        });
    }
} 