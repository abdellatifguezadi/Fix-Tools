<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition()
    {
        return [
            'name' => $this->faker->unique()->word(),
            'type' => $this->faker->randomElement(['service', 'material']),
            'description' => $this->faker->sentence(),
            'icon' => $this->faker->randomElement(['fa-tools', 'fa-wrench', 'fa-paint-brush', 'fa-bolt', 'fa-leaf', 'fa-truck', 'fa-broom', 'fa-snowflake', 'fa-fire', 'fa-hammer'])
        ];
    }

    public function service()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'service',
            ];
        });
    }

    public function material()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'material',
            ];
        });
    }
} 