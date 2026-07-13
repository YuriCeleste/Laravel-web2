<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Rotas para Categorias
Route::resource('categories', CategoryController::class)->middleware('auth');

// Rotas para Livros
Route::resource('books', BookController::class)->middleware('auth');