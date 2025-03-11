<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class Auth extends Controller
{
    
  
    public function register(Request $request)
    {

      $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => '0',
                'errors' => $validator->errors()
            ]);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $role = $user->assignRole('product_manager');
        $response = [];
        $response['name'] = $user->name;
        $response['email'] = $user->email;
        $response['role'] = $user->getRoleNames();

        return response()->json([
            'status' => '200 Ok',
            'message' => 'User created successfully',
            'data' => $response,
            'role' => $role,
        ]);
    }


    public function login(Request $request)
    
    {


        if (FacadesAuth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = FacadesAuth::user();
            $response = [];

            // Generating Token for Authentication
            
            $response['token'] = $user->createToken('GameXpress')->plainTextToken;
            $response['name'] = $user->name;
            $response['email'] = $user->email;
            return response()->json([
                'status' => '200 Ok',
                'message' => 'User logged in successfully',
                'data' => $response,
            ]);
        } else {
            return response()->json([
                'status' => '0',
                'message' => 'Invalid login details'
            ]);
        }

    }


    public function logout(Request $request)
    {
        try {

            $request->user()->currentAccessToken()->delete();

            return response()->json([
                'message' => 'User logged out successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Logout failed',
                'error' => $e->getMessage()
            ], 500); 
        }
    }

}
