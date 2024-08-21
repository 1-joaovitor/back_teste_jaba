<?php

use App\Http\Controllers\auth\LoginController;

use App\Http\Controllers\ProductController;

use App\Http\Controllers\UserContoller;
use App\Http\Controllers\CategorieController;

use Illuminate\Support\Facades\Route;


Route::post('/login', [LoginController::class, 'login']);
Route::middleware('auth:sanctum')->get('/profile', [LoginController::class, 'profile']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [UserContoller::class, 'index']);
    Route::post('/user', [UserContoller::class, 'store']);
    Route::get('/user/{id}', [UserContoller::class, 'show']);
    Route::put('/user/{id}', [UserContoller::class, 'edit']);
    Route::delete('/user/{id}', [UserContoller::class, 'destroy']);
});


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/products', [ProductController::class, 'index']);
    Route::post('/products', [ProductController::class, 'store']);
    Route::get('/products/{id}', [ProductController::class, 'show']);
    Route::put('/products/{id}', [ProductController::class, 'update']);
    Route::delete('/products/{id}', [ProductController::class, 'destroy']);
});


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/categories', [CategorieController::class, 'registerCategory']);
    Route::get('/categories', [CategorieController::class, 'getCategories']);
    Route::get('/categories/{id}', [CategorieController::class, 'getCategoryById']);
    Route::put('/categories/{id}', [CategorieController::class, 'updateCategory']);
    Route::delete('/categories/{id}', [CategorieController::class, 'deleteCategory']);
});
