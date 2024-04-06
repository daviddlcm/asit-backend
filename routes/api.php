<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ProductsController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


//protected routes
Route::get('/users', 'App\Http\Controllers\UserController@index')->middleware('auth:sanctum');
Route::get('/users/{id}', 'App\Http\Controllers\UserController@show')->middleware('auth:sanctum');
Route::delete("/users/{id}", "App\Http\Controllers\UserController@destroy")->middleware('auth:sanctum');
Route::put("/users/{id}", "App\Http\Controllers\UserController@update")->middleware('auth:sanctum');

//free routes
Route::post("/login", "App\Http\Controllers\UserController@logIn");
Route::post('/users', 'App\Http\Controllers\UserController@store');

// routes Products

Route::get('/products', 'App\Http\Controllers\ProductsController@index');
Route::post('/products','App\Http\Controllers\ProductsController@store');
Route::get('/products/categories/{id_categories}', 'App\Http\Controllers\ProductsController@productsByCategory');

// Route::get('/products/categories/{id_categories}', [ProductsController::class, 'productsByCategory']);

// routes Categories
Route::get('/categories', [CategoriesController::class, 'index']);
Route::get('/categories/{id_categories}', [CategoriesController::class, 'show']);