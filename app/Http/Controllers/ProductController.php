<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        if($user->hasRole('super_admin')){

         return response()->json([
            'status' => '200 Ok',
            'message' => 'Welcome Super Admin',
            'data' => Product::all()
        ]);
        }

        else return 'Unauthorized Access';
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        {

            $validator = Validator::make($request->all(), [
                  'name' => 'required',
                  'slug' => 'required',
              ]);
      
              if ($validator->fails()) {
                  return response()->json([
                      'status' => '0',
                      'errors' => $validator->errors()
                  ]);
              }
      
              $product = Product::create([
                  'name' => $request->name,
                  'slug' => $request->slug,
                  'price' => $request->price,
                  'stock' => $request->stock,
                  'status' => $request->status,
                  'category_id' => '1',

              ]);
      
                $response = [];
                $response['name'] = $product->name;
                $response['slug'] = $product->slug;
                $response['price'] = $product->price;
                $response['stock'] = $product->stock;
                $response['status'] = $product->status;
      
              return response()->json([
                  'status' => '200 Ok',
                  'message' => 'Product created successfully',
                  'data' => $response,
              ]);
          }
     

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
   
        $user = Auth::user();
        if ($user->hasRole('super_admin') || $user->hasRole('product_manager')) {

            $product = Product::find($id);
            return response()->json([
                'status' => '200 Ok',
                'message' => 'Welcome Super Admin',
                'data' => $product,
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();
        
        if (!$user->hasRole('super_admin') && !$user->hasRole('product_manager')) {
            return response()->json([
                'status' => '403 Forbidden',
                'message' => 'Unauthorized Access',
            ], 403);
        }
        
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'status' => '404 Not Found',
                'message' => 'Product not found',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => '400 Bad Request',
                'errors' => $validator->errors()
            ], 400);
        }

        $product->update([
            'name' => $request->name,
            'slug' => $request->slug,
            'price' => $request->price,
            'stock' => $request->stock,
            'status' => $request->status,
            'category_id' => '1',
        ]);

        return response()->json([
            'status' => '200 Ok',
            'message' => 'Product updated successfully',
            'data' => $product,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
