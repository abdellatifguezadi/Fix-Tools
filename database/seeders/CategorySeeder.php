<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        // Service Categories
        $serviceCategories = [
            'Plomberie' => [
                'description' => 'Services de plomberie et réparation',
                'icon' => 'fa-wrench'
            ],
            'Électricité' => [
                'description' => 'Services électriques et installations',
                'icon' => 'fa-bolt'
            ],
            'Peinture' => [
                'description' => 'Services de peinture et décoration',
                'icon' => 'fa-paint-brush'
            ],
            'Menuiserie' => [
                'description' => 'Services de menuiserie et charpente',
                'icon' => 'fa-hammer'
            ],
            'Chauffage' => [
                'description' => 'Services de chauffage et climatisation',
                'icon' => 'fa-fire'
            ],
            'Climatisation' => [
                'description' => 'Services de climatisation et ventilation',
                'icon' => 'fa-snowflake'
            ],
            'Jardinage' => [
                'description' => 'Services de jardinage et entretien',
                'icon' => 'fa-leaf'
            ],
            'Nettoyage' => [
                'description' => 'Services de nettoyage et entretien',
                'icon' => 'fa-broom'
            ],
            'Déménagement' => [
                'description' => 'Services de déménagement et transport',
                'icon' => 'fa-truck'
            ],
            'Bricolage' => [
                'description' => 'Services de bricolage et réparation',
                'icon' => 'fa-tools'
            ]
        ];

        foreach ($serviceCategories as $name => $details) {
            Category::create([
                'name' => $name,
                'type' => 'service',
                'description' => $details['description'],
                'icon' => $details['icon']
            ]);
        }

        // Material Categories
        $materialCategories = [
            'Outils de plomberie' => [
                'description' => 'Outils et matériels pour travaux de plomberie',
                'icon' => 'fa-wrench'
            ],
            'Outils électriques' => [
                'description' => 'Outils et équipements pour travaux électriques',
                'icon' => 'fa-bolt'
            ],
            'Matériel de peinture' => [
                'description' => 'Matériels pour peinture et décoration',
                'icon' => 'fa-paint-brush'
            ],
            'Outils de menuiserie' => [
                'description' => 'Outils et matériels pour travaux de menuiserie',
                'icon' => 'fa-hammer'
            ],
            'Équipement de chauffage' => [
                'description' => 'Équipements et pièces pour systèmes de chauffage',
                'icon' => 'fa-fire'
            ],
            'Équipement climatique' => [
                'description' => 'Matériels pour installation et maintenance de climatisation',
                'icon' => 'fa-snowflake'
            ],
            'Outils de jardinage' => [
                'description' => 'Outils et équipements pour entretien de jardin',
                'icon' => 'fa-leaf'
            ],
            'Matériel de nettoyage' => [
                'description' => 'Produits et matériels de nettoyage',
                'icon' => 'fa-broom'
            ],
            'Équipement de déménagement' => [
                'description' => 'Équipements pour faciliter le déménagement',
                'icon' => 'fa-truck'
            ],
            'Outils de bricolage' => [
                'description' => 'Outils divers pour petits travaux',
                'icon' => 'fa-tools'
            ]
        ];

        foreach ($materialCategories as $name => $details) {
            Category::create([
                'name' => $name,
                'type' => 'material',
                'description' => $details['description'],
                'icon' => $details['icon']
            ]);
        }
    }
} 