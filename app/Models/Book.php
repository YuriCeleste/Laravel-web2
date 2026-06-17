<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'pages', 'author_id', 'category_id', 'publisher_id', 'published_year'];

    // ... relacionamentos existentes ...
public function users()
{
    return $this->belongsToMany(User::class, 'borrowings')
                ->withPivot('id', 'borrowed_at', 'returned_at')
                ->withTimestamps();
}

    // ... outros métodos ...
}