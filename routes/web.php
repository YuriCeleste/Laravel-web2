<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BorrowingController;


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Rotas para Categorias
Route::resource('categories', CategoryController::class)->middleware('auth');

// Rotas para Livros
Route::resource('books', BookController::class)->middleware('auth');

// Rotas para Usuários (apenas index, show, edit, update)
Route::resource('users', UserController::class)->except(['create', 'store', 'destroy'])->middleware('auth');

// Rotas para Empréstimos
Route::post('/books/{book}/borrow', [BorrowingController::class, 'store'])->name('books.borrow')->middleware('auth');
Route::patch('/borrowings/{borrowing}/return', [BorrowingController::class, 'returnBook'])->name('borrowings.return')->middleware('auth');
Route::get('/users/{user}/borrowings', [BorrowingController::class, 'userBorrowings'])->name('users.borrowings')->middleware('auth');