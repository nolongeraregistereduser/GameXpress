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
            'product_id' => 'required',
            'image_url' => 'required',
            'is_primary' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => '0',
                'errors' => $validator->errors()
            ]);
        }

        if ($request->is_primary) {
            ProductImage::where('product_id', $request->product_id)
            ->where('is_primary', true)
            ->update(['is_primary' => false]);
        }

        $productImage = ProductImage::create([
            'product_id' => $request->product_id,
            'image_url' => $request->image_url,
            'is_primary' => $request->is_primary,
        ]);




    }
}
