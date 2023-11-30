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

Route::get('/product', [productController::class, 'index']);

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
