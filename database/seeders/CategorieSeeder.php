<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categorie;

class CategorieSeeder extends Seeder
{
    public function run()
{
    $categories = ['Informatique', 'Électrique', 'Électronique', 'Mobilier', 'Papeterie'];

    foreach ($categories as $nom) {
        Categorie::firstOrCreate(['nom' => $nom]);
    }
}
}
