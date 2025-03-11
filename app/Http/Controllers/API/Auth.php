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

          // creating token for user 

        $response = [];
        $response['token'] = $user->createToken('GameXpress')->plainTextToken;
        $response['name'] = $user->name;
        $response['email'] = $user->email;

        return response()->json([
            'status' => '200 Ok',
            'message' => 'User created successfully',
            'data' => $response,
        ]);
    }


    public function login(Request $request)
    
    {


        if (FacadesAuth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = FacadesAuth::user();
            $response = [];
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

}
