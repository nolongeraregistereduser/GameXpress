<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class DashboardController extends Controller
{
    
public function index()
{

    $user = Auth::user();

    if ($user->hasRole('super_admin')) {
        return response()->json([
            'status' => '200 Ok',
            'message' => 'Welcome Super Admin',
            'data' => $user
        ]);
    }

    else if ($user->hasRole('product_manager')) {
        return response()->json([
            'status' => '200 Ok',
            'message' => 'Welcome Product Manager',
            'data' => $user
        ]);
    }

    else if ($user->hasRole('user_manager')) {
        return response()->json([
            'status' => '200 Ok',
            'message' => 'Welcome User Manager',
            'data' => $user
        ]);
    }

    else {
        return response()->json([
            'status' => '403',
            'message' => 'Unauthorized Access',
        ]);
    }
}


    public function stats()
    {
        $user = Auth::user();

        if($user->hasRole('super_admin')){

            return response()->json([
                'status' => '200 Ok',
                'message' => 'Super Admin Statistics',
                'data' => [
                    'total_users' => User::count(),
                    // i will add other statistics when impplementing categ and products in db 
                ]
            ]);
        }
        
    }
}
