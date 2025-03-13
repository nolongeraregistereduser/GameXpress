<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    
   
    public function index(){


        $user = Auth::user();

        if($user->hasRole('super_admin') || $user->hasRole('product_manager')){

         return response()->json([
            'status' => '200 Ok',
            'message' => 'Welcome Super Admin',
            'data' => Category::all()
        ]);
        }

        else return 'Unauthorized Access';

        return response()->json([
            'message' => '2OO Ok',
        ]);
    }
  


    public function store (Request $request){


        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required',
        ]);
        $category = Category::create([
            'name' => $request->name,
            'slug' => $request->slug,
        ]);

        return response()->json([
            'status' => '200 Ok',
            'message' => 'Category created successfully',
            'data' => $category
        ]);
    }


    public function show($id){

        $user = Auth::user();
        if($user->hasRole('super_admin') || $user->hasRole('product_manager')){

 
            $category = Category::find($id);
            if($category){
                return response()->json([
                    'status' => '200 Ok',
                    'message' => 'Category found',
                    'data' => $category
                ]);
            }
            else{
                return response()->json([
                    'status' => '404 Not Found',
                    'message' => 'Category not found',
                ]);
            }
  

    }}


    public function update(Request $request, $id)
    {
        $user = Auth::user();
        
        if (!$user->hasRole('super_admin') && !$user->hasRole('product_manager')) {
            return response()->json([
                'status' => '403 Forbidden',
                'message' => 'Unauthorized Access',
            ], 403);
        }
        
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'status' => '404 Not Found',
                'message' => 'Product not found',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => '400 Bad Request',
                'errors' => $validator->errors()
            ], 400);
        }

        $category->update([
            'name' => $request->name,
            'slug' => $request->slug,

        ]);

        return response()->json([
            'status' => '200 Ok',
            'message' => 'Product updated successfully',
            'data' => $category,
        ]);
    }

      

}
