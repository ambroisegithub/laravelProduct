<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Storage;
class ProductController extends Controller
{

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'slug' => 'required',
                'price' => 'required',
                'description' => 'required',
                'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $productData = $request->all();

            // Handle image upload
            if ($request->hasFile('image')) {
                $image = $request->file('image');

                // Log information about the image
                Log::info('Image details:', [
                    'original_name' => $image->getClientOriginalName(),
                    'extension' => $image->getClientOriginalExtension(),
                    'size' => $image->getSize(),
                    'mime_type' => $image->getMimeType(),
                ]);

                $imagePath = $image->store('public/products');
                $productData['image'] = Storage::url($imagePath);
            }

            $product = Product::create($productData);

            return response()->json(['message' => 'Product created successfully', 'data' => $product], 201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->validator->errors()], 422);
        }
    }


    public function index()
    {
        return Product::all();
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

    public function search($name)
    {
        return Product::where('name', 'like', '%' . $name . '%')->get();
    }


    public function showUploadForm()
    {
        return view('upload');
    }

    public function storeUploads(Request $request)
    {
        $response = cloudinary()->upload($request->file('file')->getRealPath())->getSecurePath();

        dd($response);

        return back()
            ->with('success', 'File uploaded successfully');
    }
    
}


