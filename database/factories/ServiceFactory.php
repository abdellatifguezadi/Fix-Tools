<?php

namespace Database\Factories;

use App\Models\Service;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceFactory extends Factory
{
    protected $model = Service::class;

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
        $serviceName = $this->faker->randomElement($categories[$category]);

        return [
            'name' => $serviceName,
            'description' => "Service professionnel de {$category} avec expertise et garantie.",
            'category_id' => Category::factory(),
            'base_price' => $this->faker->randomFloat(2, 50, 500),
            'professional_id' => User::factory(),
            'is_available' => $this->faker->boolean(80),
            'image_path' => $this->faker->imageUrl(640, 480, 'service'),
        ];
    }
} 