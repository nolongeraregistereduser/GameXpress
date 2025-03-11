<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Role;
use App\Models\Permission;


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
                    'total_products' => Product::count(),
                    'total_categories' => Category::count(),
                    'total_roles' => Role::count(),
                    'total_permissions' => Permission::count(),
                ]
            ]);
        }
        
    }
}
