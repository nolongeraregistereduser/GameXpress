<?php

namespace App\Http\Controllers;

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
}
