<?php

use App\Http\Controllers\productController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// user
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'Login']);

Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

// Public Routes
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/search/{name}', [ProductController::class, 'search']);
Route::get('/products/{id}', [ProductController::class, 'show']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



// Protected Routes

Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::patch('/products/{id}', [productController::class, 'update']);
    Route::delete('/products/{id}', [productController::class, 'destroy']);
    Route::delete('/products', [ProductController::class, 'deleteAll']);
    Route::post('/products', [productController::class, 'store']);
});


// Route::post('/products', function () {
//     return Product::create([
//         'name' => 'Product One',
//         'slug' => 'This is slug One',
//         'discription' => 'This is Product One',
//         'price' => '99.9'
//     ]);
// });