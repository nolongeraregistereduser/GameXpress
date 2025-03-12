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
                  'price' => 'required',
              ]);
      
              if ($validator->fails()) {
                  return response()->json([
                      'status' => '0',
                      'errors' => $validator->errors()
                  ]);
              }
      
              $product = Product::create([
                  'name' => $request->name,
                  'price' => $request->price,
              ]);
      
              $response = [];
              $response['name'] = $product->name;
              $response['price'] = $product->price;
      
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
    public function show(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
