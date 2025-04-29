<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $serviceCategories = [
            'Plomberie',
            'Électricité',
            'Peinture',
            'Menuiserie',
            'Chauffage',
            'Climatisation',
            'Jardinage',
            'Nettoyage',
            'Déménagement',
            'Bricolage'
        ];

        foreach ($serviceCategories as $name) {
            Category::create([
                'name' => $name,
                'type' => 'service'
            ]);
        }

        $materialCategories = [
            'Outils de plomberie',
            'Outils électriques',
            'Matériel de peinture',
            'Outils de menuiserie',
            'Équipement de chauffage',
            'Équipement climatique',
            'Outils de jardinage',
            'Matériel de nettoyage',
            'Équipement de déménagement',
            'Outils de bricolage'
        ];

        foreach ($materialCategories as $name) {
            Category::create([
                'name' => $name,
                'type' => 'material'
            ]);
        }
    }
} 