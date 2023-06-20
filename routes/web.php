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
use App\Http\Controllers\ReserveController;


Route::get('/', function () {
    return view('welcome');
});




Route::prefix('admin')->group(function () {

    //作品一覧画面
    //URI: /movies
    //コントローラ: AdminController
    //関数: movies
    Route::get('/movies', [AdminController::class, 'movies'])->name('movie.list');

    //作品登録画面
    //URI: /admin/movies/create
    //コントローラ: AdminController
    //関数: create
    Route::get('/movies/create', [AdminController::class, 'create'])->name('movie.create');

    //作品登録エンドポイント
    //URI: /admin/movies/store
    //コントローラ: AdminController
    //関数: store
    Route::post('/movies/store', [AdminController::class, 'store'])->name('movie.store');

    //作品詳細画面
    //URI: /admin/movies/{movie_id}
    //Param: movie_id(作品ID)
    //コントローラ: AdminController
    //関数: adminmovieinfo
    Route::get('/movies/{id}', [AdminController::class, 'adminmovieinfo'])->name('movie.admininfo');

    //作品編集画面
    //URI: /admin/movies/{movie_id}/edit
    //Param: movie_id(作品ID)
    //コントローラ: AdminController
    //関数: edit
    Route::get('/movies/{id}/edit', [AdminController::class, 'edit'])->name('movie.edit');

    //作品更新エンドポイント
    //URI: /admin/movies/{movie_id}/update
    //Param: movie_id(作品ID)
    //コントローラ: AdminController
    //関数: update
    Route::patch('/movies/{id}/update', [AdminController::class, 'update'])->name('movie.update');

    //作品削除エンドポイント
    //URI: /admin/movies/{movie_id}/schedules/{schedule_id}/destroy
    //Param: movie_id(作品ID)
    //コントローラ: AdminController
    //関数: destroy
    Route::delete('/movies/{id}/destroy', [AdminController::class, 'destroy'])->name('movie.destroy');

    //スケジュール一覧画面
    //URI: /admin/schedules
    //コントローラ: AdminController
    //関数: getallschedules
    Route::get('/schedules', [AdminController::class, 'getallschedules'])->name('schedule.getall');

    //スケジュール詳細画面(スケジュールID)
    //URI: /admin/schedules/{schedule_id}
    //Param: schedule_id(スケジュールID)
    //コントローラ: AdminController
    //関数: getschedulebyid
    Route::get('/schedules/{id}', [AdminController::class, 'getschedulebyid'])->name('schedule.getbyid');

    //スケジュール作成画面
    //URI: /admin/movies/{movie_id}/schedules/create
    //Param: movie_id(作品ID)
    //コントローラ: AdminController
    //関数: createschedulemenu
    Route::get('/movies/{id}/schedules/create', [AdminController::class, 'createschedulemenu'])->name('schedule.create');

    //スケジュール作成エンドポイント
    //URI: /admin/movies/{movie_id}/schedules/store
    //Param: movie_id(作品ID)
    //コントローラ: AdminController
    //関数: storeschedule
    Route::post('/movies/{id}/schedules/store', [AdminController::class, 'storeschedule'])->name('schedule.store');

    //スケジュール編集画面
    //URI: /admin/movies/{movie_id}/schedules/{schedule_id}/edit
    //Param: schedule_id(スケジュールID)
    //コントローラ: AdminController
    //関数: editschedule
    Route::get('/schedules/{scheduleId}/edit', [AdminController::class, 'editschedule'])->name('schedule.edit');

    //スケジュール更新エンドポイント
    //URI: /admin/movies/{movie_id}/schedules/{schedule_id}/update
    //Param: schedule_id(スケジュールID)
    //コントローラ: AdminController
    //関数: updateschedule
    Route::patch('/schedules/{id}/update', [AdminController::class, 'updateschedule'])->name('schedule.update');

    //スケジュール削除エンドポイント
    //URI: /admin/movies/{movie_id}/schedules/{schedule_id}/destroy
    //Param: schedule_id(スケジュールID)
    //コントローラ: AdminController
    //関数: destroyschedule
    Route::delete('/schedules/{id}/destroy', [AdminController::class, 'destroyschedule'])->name('schedule.destroy');

});

Route::prefix('movies')->group(function () {

    //座席表
    //URI: /movies/{movie_id}/schedules/{schedule_id}/sheets
    //Param: screening_date(上映日付)
    //コントローラ: ReserveController
    //関数: sheetinfo
    Route::get('/{movie_id}/schedules/{schedule_id}/sheets', [ReserveController::class, 'sheetinfo'])->name('sheet.select');

    //座席予約フォーム画面(reserveform)
    //URI: /movies/{movie_id}/schedules/{schedule_id}/reservations/create
    //パラメータ: screening_date(上映日付), sheet_id(座席番号)
    //コントローラ: ReserveController
    //関数: reserveform
    Route::get('/{movie_id}/schedules/{schedule_id}/reservations/create', [ReserveController::class, 'reserveform'])->name('sheet.reserveform');

    //映画情報/予約完了画面
    //URI: /movies/{movie_id}
    //Param: movie_id(作品ID)
    //コントローラ: MovieController
    //関数: movieinfo
    Route::get('/{id}', [MovieController::class, 'movieinfo'])->name('movie.info');


    //映画検索画面
    //URI: /movies
    //コントローラ: MovieController
    //関数: index
    Route::get('/', [MovieController::class, 'index'])->name('movie.search');
});

//座席予約フォーム登録先
//URI: /reservations/store
//Form: schedule_date(スケジュールID), sheet_id(座席番号), name(名前), email(メールアドレス),screening_date(上映日付)
//コントローラ: ReserveController
//関数: reservestore
Route::post('/reservations/store', [ReserveController::class, 'reservestore'])->name('sheet.reservestore');

//座席一覧
//URI: /sheets
//コントローラ: MovieController
//関数: sheets
Route::get('/sheets', [MovieController::class, 'sheets'])->name('sheet.list');

Route::get('/practice', [PracticeController::class, 'sample']);
Route::get('/practice2', [PracticeController::class, 'sample2']);
Route::get('/practice3', [PracticeController::class, 'sample3']);
Route::get('/getPractice', [PracticeController::class, 'getPractice']);


