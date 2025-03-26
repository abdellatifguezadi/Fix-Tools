<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition()
    {
        $categories = [
            'Plomberie' => [
                'Installation de robinets',
                'Réparation de fuites',
                'Installation de WC',
                'Débouchage de canalisation'
            ],
            'Électricité' => [
                'Installation électrique',
                'Dépannage électrique',
                'Mise aux normes',
                'Installation domotique'
            ],
            'Peinture' => [
                'Peinture intérieure',
                'Peinture extérieure',
                'Finition murale',
                'Décoration murale'
            ],
            'Menuiserie' => [
                'Fabrication de meubles',
                'Installation de portes',
                'Installation de fenêtres',
                'Travaux de charpente'
            ],
            'Chauffage' => [
                'Installation de chaudière',
                'Maintenance chauffage',
                'Installation radiateurs',
                'Dépannage chauffage'
            ],
            'Climatisation' => [
                'Installation climatisation',
                'Maintenance climatisation',
                'Nettoyage climatisation',
                'Dépannage climatisation'
            ],
            'Jardinage' => [
                'Tonte de pelouse',
                'Taille de haies',
                'Entretien jardin',
                'Aménagement paysager'
            ],
            'Nettoyage' => [
                'Nettoyage maison',
                'Nettoyage vitres',
                'Nettoyage après travaux',
                'Nettoyage professionnel'
            ],
            'Déménagement' => [
                'Déménagement complet',
                'Transport de meubles',
                'Déménagement local',
                'Déménagement long distance'
            ],
            'Bricolage' => [
                'Petits travaux',
                'Réparations diverses',
                'Montage meubles',
                'Installation étagères'
            ]
        ];

        $category = $this->faker->randomElement(array_keys($categories));

        return [
            'name' => $category,
            'description' => $this->faker->sentence(),
            'type' => 'service',
        ];
    }
} 