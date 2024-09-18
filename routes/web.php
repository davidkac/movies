<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\FavoritesController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});



Route::get('/movies', [MovieController::class, 'index'])->name('movies.index');
Route::get('/movies/create', [MovieController::class, 'create'])->name('movies.create')->middleware('auth');
Route::get('/movies/{movie}', [MovieController::class, 'show'])->name('movie.show');
Route::post('/movies', [MovieController::class, 'store'])->name('movies.store')->middleware('auth');
Route::post('/movies/{movie}/comments',[CommentController::class, 'store'])->name('comment.store')->middleware('auth');
Route::get('/movies/{movie}/edit', [MovieController::class, 'edit'])->name('movies.edit')
->middleware('auth')
->can('edit', 'movie');
Route::put('/movies/{movie}', [MovieController::class, 'update'])->name('movies.update')->middleware('auth');
Route::delete('/movies/{movie}', [MovieController::class, 'destroy'])->name('movies.destroy')
->middleware('auth')
->can('delete', 'movie');
Route::post('/movies/{movie}/rate', [RatingController::class, 'store'])->name('ratings.store');
Route::delete('/movies/{movie}/comments/{comment}', [CommentController::class, 'destroy'])->name('comment.destroy')->middleware('auth');
Route::get('/top-rated-movies', [MovieController::class, 'topRatedMovies'])->name('top.movies');

Route::get('/register/create', [RegisterController::class, 'create'])->name('register.create');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
Route::get('/login/create', [LoginController::class, 'index'])->name('login.create');
Route::post('/login', [LoginController::class, 'store'])->name('login.store');
Route::post('/logout', [LoginController::class, 'destroy']);


Route::middleware('auth')->group(function () {
    Route::post('/movies/{movie}/favorites', [FavoritesController::class, 'addToFavorites'])->name('favorites.add');
    Route::delete('/movies/{movie}/favorites', [FavoritesController::class, 'removeFromFavorites'])->name('favorites.remove');
    Route::get('/favorites', [FavoritesController::class, 'index'])->name('favorites.index');
});
