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


    
}
