<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


//protected routes
Route::get('/users', 'App\Http\Controllers\UserController@index')->middleware('auth:sanctum');
Route::get('/users/{id}', 'App\Http\Controllers\UserController@show')->middleware('auth:sanctum');
Route::delete("/users/{id}", "App\Http\Controllers\UserController@destroy")->middleware('auth:sanctum');
Route::put("/users/{id}", "App\Http\Controllers\UserController@update")->middleware('auth:sanctum');
Route::post('/users', 'App\Http\Controllers\UserController@store')->middleware('auth:sanctum');
Route::post("/changePassword/{userId}", "App\Http\Controllers\UserController@updatePassword")->middleware('auth:sanctum');

//free routes
Route::post("/login", "App\Http\Controllers\UserController@logIn");
