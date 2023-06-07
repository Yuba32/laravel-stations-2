<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\PracticeController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\AdminController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/practice', [PracticeController::class, 'sample']);
Route::get('/practice2', [PracticeController::class, 'sample2']);
Route::get('/practice3', [PracticeController::class, 'sample3']);
Route::get('/getPractice', [PracticeController::class, 'getPractice']);
Route::get('/movies', [MovieController::class, 'index'])->name('movie.search');

Route::get('/admin/movies', [AdminController::class, 'movies'])->name('movie.list');

Route::get('/admin/movies/create', [AdminController::class, 'create'])->name('movie.create');
Route::post('/admin/movies/store', [AdminController::class, 'store'])->name('movie.store');

Route::get('/admin/movies/{id}/edit', [AdminController::class, 'edit'])->name('movie.edit');

Route::patch('/admin/movies/{id}/update', [AdminController::class, 'update'])->name('movie.update');

Route::delete('/admin/movies/{id}/destroy', [AdminController::class, 'destroy'])->name('movie.destroy');
