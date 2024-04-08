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
Route::post('/users', 'App\Http\Controllers\UserController@store')->middleware('auth:sanctum');
Route::post("/changePassword/{userId}", "App\Http\Controllers\UserController@updatePassword")->middleware('auth:sanctum');

//free routes
Route::post("/login", "App\Http\Controllers\UserController@logIn");

// routes Products

Route::get('/products', 'App\Http\Controllers\ProductsController@index');
Route::get('/products/{id_products}', 'App\Http\Controllers\ProductsController@show');
Route::post('/products','App\Http\Controllers\ProductsController@store');
Route::put('/products/{id_products}','App\Http\Controllers\ProductsController@update');
Route::get('/products/categories/{id_categories}', 'App\Http\Controllers\ProductsController@productsByCategory');
Route::delete('products/{id_products}','App\Http\Controllers\ProductsController@destroy');

// Route::get('/products/categories/{id_categories}', [ProductsController::class, 'productsByCategory']);

// routes Categories
Route::get('/categories', [CategoriesController::class, 'index']);
Route::get('/categories/{id_categories}', [CategoriesController::class, 'show']);
Route::post('/categories', [CategoriesController::class, 'store']);
Route::put('/categories/{id_categories}',[CategoriesController::class, 'update']);
Route::delete('/categories/{id_categories}',[CategoriesController::class, 'destroy']);
