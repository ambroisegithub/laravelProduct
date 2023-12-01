<?php

use App\Http\Controllers\productController;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/products', [ProductController::class, 'index']);
Route::post('/products', [ProductController::class, 'store']);
Route::get('/products/{id}', [ProductController::class, 'show']);
Route::patch('/products/{id}', [productController::class, 'update']);
Route::delete('/products/{id}', [productController::class, 'destroy']);
Route::delete('/products', [ProductController::class, 'deleteAll']); // New route for deleting all products
Route::get('/products/search/{name}', [ProductController::class, 'search']);
// Route::post('/products', function () {
//     return Product::create([
//         'name' => 'Product One',
//         'slug' => 'This is slug One',
//         'discription' => 'This is Product One',
//         'price' => '99.9'
//     ]);
// });

Route::post('/products', [productController::class, 'store']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
