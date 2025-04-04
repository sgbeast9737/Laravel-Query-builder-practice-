<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

use App\Http\Middleware\checkToken;
use App\Http\Middleware\test;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\DirectorController;
use App\Http\Controllers\PracticeController;

Route::get('/user', function (Request $request) {
    return DB::table('user')->get();
})->middleware('auth:sanctum');

Route::get('/', function (Request $request) {
    return [
        "status" => "success",
        "message" => "Hello from laravel framework api backend"
    ];
});

Route::controller(MovieController::class)->group(function(){
    Route::get('/movies','index');
    Route::get('/movies/info','info');
    Route::get('/movies/{id}','show');
});

Route::controller(DirectorController::class)->group(function(){
    Route::get('/directors','index');
    Route::get('/directors/movies','withMovies');
    Route::get('/directors/{id}','show');
    Route::get('/directors/{id}/movies','WithAllMoviesInfo');
});

Route::controller(PracticeController::class)->group(function(){
    Route::get("/practice","index")->middleware([checkToken::class,test::class]);
});