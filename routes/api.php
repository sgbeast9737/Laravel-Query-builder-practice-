<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\MovieController;
use App\Http\Controllers\DirectorController;

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