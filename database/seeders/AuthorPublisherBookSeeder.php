<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Publisher;

class AuthorPublisherBookSeeder extends Seeder
{
    public function run(): void
    {
        // Gera 30 autores, cada um com 5 livros
        Author::factory(30)->create()->each(function ($author) {
            // Cria uma editora para cada autor
            $publisher = Publisher::factory()->create();

            // Cria 5 livros para cada autor
            Book::factory(5)->create([
                'author_id' => $author->id,
                'category_id' => Category::inRandomOrder()->first()->id,
                'publisher_id' => $publisher->id,
            ]);
        });
    }
}