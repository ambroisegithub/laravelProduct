<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    public function index()
    {
        return Product::all();
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'slug' => 'required',
                'price' => 'required',
                'discription' => 'required', // corrected the field name
            ]);

            $product = Product::create($request->all());

            return response()->json(['message' => 'Product created successfully', 'data' => $product], 201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->validator->errors()], 422);
        }
    }

    public function show($id)
    {
        $product = Product::find($id);

        if ($product) {
            return response()->json(['message' => 'Product retrieved successfully', 'data' => $product]);
        } else {
            return response()->json(['message' => 'Product not found'], 404);
        }
    }
    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        if ($product) {
            $product->update($request->all());
            return response()->json(['message' => 'Product Updated Successfully', 'data' => $product]);
        } else {
            return response()->json(['message' => 'Product Not Found'], 404);
        }
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        if ($product) {
            Product::destroy($id);
            return response()->json(['message' => 'Product Deleted Succussfully', 'data' => $product]);
        } else {
            return response()->json(['message' => 'Product Not found'], 404);
        }
    }

    public function deleteAll()
    {
        Product::truncate(); // Deletes all records from the products table
        return response()->json(['message' => 'All products deleted successfully']);
    }

    public function search($name){
        return Product::where('name','like','%'.$name.'%')->get();
    }
}
