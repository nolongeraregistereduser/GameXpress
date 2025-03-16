<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use App\Models\ProductImage;


use Illuminate\Http\Request;

class ProductImageController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => '200 Ok',
            'message' => 'Product Image Controller'
        ]);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_primary' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => '400 Bad Request',
                'errors' => $validator->errors()
            ], 400);
        }

        if ($request->is_primary) {
            ProductImage::where('product_id', $request->product_id)
                ->where('is_primary', true)
                ->update(['is_primary' => false]);
        }

        // Handle file upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            
            // Store the file in the public disk under product-images directory
            $path = $image->storeAs('product-images', $imageName, 'public');
            
            $productImage = ProductImage::create([
                'product_id' => $request->product_id,
                'image_url' => '/storage/' . $path,
                'is_primary' => $request->is_primary,
            ]);

            return response()->json([
                'status' => '200 Ok',
                'message' => 'Product Image Uploaded Successfully',
                'data' => $productImage
            ]);
        }
        
        return response()->json([
            'status' => '400 Bad Request',
            'message' => 'No image file provided'
        ], 400);
    }


    public function destroy($id)
    {
        $productImage = ProductImage::find($id);

        if (!$productImage) {
            return response()->json([
                'status' => '0',
                'message' => 'Product Image not found'
            ]);
        }

        $productImage->delete();

        return response()->json([
            'status' => '2OO Ok',
            'message' => 'Product Image Deleted Successfully'
        ]);
    }
}
