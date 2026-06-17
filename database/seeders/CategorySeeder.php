<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Ficção',
            'Não Ficção',
            'Fantasia',
            'Ciência',
            'Biografia',
            'História',
            'Romance',
            'Terror',
            'Aventura',
            'Poesia'
        ];

        foreach ($categories as $category) {
            Category::create(['name' => $category]);
        }
    }
}