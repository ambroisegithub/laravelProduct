<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class productController extends Controller
{
    //
    public function index()
    {
        return Product::all();
    }
    public function store(Request $request)
    {
        return Product::create($request->all());
    }
}
