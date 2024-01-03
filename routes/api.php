<?php

use App\Http\Controllers\productController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;


// user
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'Login']);
Route::delete('/DeleteAllUsers', [AuthController::class, 'deleteAll']);

Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

// Update the namespace here as well
Route::post('/accounts', [AccountController::class, 'create']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

// Public Routes
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/search/{name}', [ProductController::class, 'search']);
Route::get('/products/{id}', [ProductController::class, 'show']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/products', [productController::class, 'store']);


// Protected Routes

Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::patch('/products/{id}', [productController::class, 'update']);
    Route::delete('/products/{id}', [productController::class, 'destroy']);
    Route::delete('/products', [ProductController::class, 'deleteAll']);
});

//pregnant women account completion

// Index
Route::get('/accounts', [AccountController::class, 'Getall']);

// Store
// Route::post('/pregnant', [PregnantWomenAccountcompleteController::class, 'store']);

// Show
Route::get('/accounts/{id}', [AccountController::class, 'getById']);

// Update
Route::patch('/accounts/{id}', [AccountController::class, 'updateAccount']);

// Destroy
Route::delete('/accounts/{id}', [AccountController::class, 'destroyAccount']);

// Delete All
Route::delete('/accounts', [AccountController::class, 'deleteAll']);

// Search
Route::get('/accounts/search/{fullname}', [AccountController::class, 'search']);
