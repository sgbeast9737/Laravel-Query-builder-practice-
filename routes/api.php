<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

Route::get('/user', function (Request $request) {
    return DB::table('user')->get();
})->middleware('auth:sanctum');

Route::get('/', function (Request $request) {
    return [
        "status" => "success",
        "message" => "Hello from laravel framework api backend"
    ];
});

Route::get('/movies',function() {
    return ["movie" => "3 ediot"];
});