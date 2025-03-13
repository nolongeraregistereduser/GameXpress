<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    
   
    public function index(){


        return response()->json([
            'message' => '2OO Ok',
        ]);
    }
  

}
