<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run()
    {
        $professionals = User::where('role', 'professional')->get();

        if ($professionals->isEmpty()) {
            $this->command->info('No professionals found. Please run UserSeeder first.');
            return;
        }

        Category::all()->each(function ($category) use ($professionals) {
            Service::factory()
                ->count(1)
                ->for($category)
                ->for($professionals->random(), 'professional')
                ->create();
        });
    }

    private function getServiceName($category)
    {
        $services = [
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

        return $services[$category][array_rand($services[$category])];
    }

    private function getServiceDescription($category)
    {
        return "Service professionnel de {$category} avec expertise et garantie.";
    }

    private function getServiceImage($category)
    {
        // You can replace these with actual image URLs
        $images = [
            'Plomberie' => 'https://images.unsplash.com/photo-1581244277943-fe4a9c777189',
            'Électricité' => 'https://images.unsplash.com/photo-1621905251918-48416bd8575a',
            'Peinture' => 'https://images.unsplash.com/photo-1589939705384-5185137a7f0f',
            'Menuiserie' => 'https://images.unsplash.com/photo-1581539250439-c96689b516dd',
            'Chauffage' => 'https://images.unsplash.com/photo-1584267385494-9fdd01a73037',
            'Climatisation' => 'https://images.unsplash.com/photo-1584267385494-9fdd01a73037',
            'Jardinage' => 'https://images.unsplash.com/photo-1558904541-efa84396f7c8',
            'Nettoyage' => 'https://images.unsplash.com/photo-1581578731548-c64695cc6952',
            'Déménagement' => 'https://images.unsplash.com/photo-1600880292203-757bb62b4baf',
            'Bricolage' => 'https://images.unsplash.com/photo-1581539250439-c96689b516dd'
        ];

        return $images[$category];
    }
} 