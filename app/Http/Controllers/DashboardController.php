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

    else {
        return response()->json([
            'status' => '403',
            'message' => 'Unauthorized Access',
        ]);
    }
}

}
