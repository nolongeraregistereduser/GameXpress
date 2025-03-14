<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;


class UserController extends Controller
{
    public function index(){

   if(auth()->user()->hasRole('super_admin') || auth()->user()->hasRole('user_manager')){

    if(auth()->user()->hasRole('super_admin')){
        return response()->json([
            'message' => 'You are super admin',
        ]);

    }
    else{
        return response()->json([
            'message' => 'You are user manager',
        ]);
    }       
                           }
    }


  public function show($id){

    $user = User::find($id);

    if(auth()->user()->hasRole('super_admin') || auth()->user()->hasRole('user_manager')){

       if($user){
        return response()->json([
            'message' => 'User found',
            'data' => $user
        ]);
       }else{
        return response()->json([
            'message' => 'User not found'
        ]);

                                                                                     }

  } 

}

public function store(Request $request){

    if(auth()->user()->hasRole('super_admin') || auth()->user()->hasRole('user_manager')){

        $validator = validator($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'product_manager'
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ]);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'product_manager',
        ]);

        return response()->json([
            'message' => 'User created',
            'data' => $user,
        ]);
    }
  }


  public function destroy($id){

    $user = User::find($id);

    if(auth()->user()->hasRole('super_admin') || auth()->user()->hasRole('user_manager')){

        if($user){
            $user->delete();
            return response()->json([
                'message' => 'User deleted',
            ]);
        }else{
            return response()->json([
                'message' => 'User not found'
            ]);
        }
    }
  }

}