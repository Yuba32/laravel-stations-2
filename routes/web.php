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

Route::get('/admin/movies/{id}', [AdminController::class, 'adminmovieinfo'])->name('movie.admininfo');

Route::get('/admin/movies/{id}/edit', [AdminController::class, 'edit'])->name('movie.edit');

Route::patch('/admin/movies/{id}/update', [AdminController::class, 'update'])->name('movie.update');

Route::delete('/admin/movies/{id}/destroy', [AdminController::class, 'destroy'])->name('movie.destroy');

//スケジュール一覧
Route::get('/admin/schedules', [AdminController::class, 'getallschedules'])->name('schedule.getall');

//スケジュール詳細(スケジュールID)
Route::get('/admin/schedules/{id}', [AdminController::class, 'getschedulebyid'])->name('schedule.getbyid');

//スケジュール作成画面
Route::get('/admin/movies/{id}/schedules/create', [AdminController::class, 'createschedulemenu'])->name('schedule.create');
Route::post('/admin/movies/{id}/schedules/store', [AdminController::class, 'storeschedule'])->name('schedule.store');

//スケジュール編集画面
Route::get('/admin/schedules/{scheduleId}/edit', [AdminController::class, 'editschedule'])->name('schedule.edit');

//スケジュール更新
Route::patch('/admin/schedules/{id}/update', [AdminController::class, 'updateschedule'])->name('schedule.update');

//スケジュール削除
Route::delete('/admin/schedules/{id}/destroy', [AdminController::class, 'destroyschedule'])->name('schedule.destroy');

Route::get('/sheets', [MovieController::class, 'sheets'])->name('sheet.list');

Route::get('/movies/{id}', [MovieController::class, 'movieinfo'])->name('movie.info');


