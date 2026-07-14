<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'pages',
        'author_id',
        'category_id',
        'publisher_id',
        'published_year',
        'cover_image'
    ];

    // Relacionamento com Author
    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    // Relacionamento com Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relacionamento com Publisher
    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }

    // Relacionamento com User (empréstimos)
    public function users()
    {
        return $this->belongsToMany(User::class, 'borrowings')
                    ->withPivot('id', 'borrowed_at', 'returned_at')
                    ->withTimestamps();
    }
}
