<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserAuthController extends Controller
{
    //Register user
    public function register(Request $request)
    {
        //validate
        $validation = $request->validate([
            'name'=>'required|string',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|min:8|confirmed',
            'phone'=>'required|string',
            'address'=>'required|string',
            'is_worker'=>'string',
        ]);

        //create user
        $user=User::create([
            'name'=> $validation['name'],
            'email'=> $validation['email'],
            'password'=>bcrypt($validation['password']),
            'phone'=> $validation['phone'],
            'address'=> $validation['address'],
            'is_worker'=> $validation['is_worker'],
        ]);

        //return user & token
        return response([
            'user'=>$user,
            'token'=>$user->createToken('secret')->plainTextToken
        ]);
    }

    //Login user
    public function login(Request $request)
    {
        //validate
        $validation = $request->validate([
            'email'=>'required|email',
            'password'=>'required|min:8',
        ]);
        //attempt login
        if(!Auth::attempt($validation))
        {
            return response(['message' =>'Invalid user.'],403);
        }
        //return user & token
        return response([
            'user'=>auth()->user(),
            'token'=>auth()->user()->createToken('secret')->plainTextToken
        ],200);
    }

    //logout
    public function logout()
    {
        auth()->user()->tokens()->delete();
        return response(['message'=>'Logout success'],200);
    }

    //get user details
    public function show()
    {
        return response(['user'=>auth()->user()],200);
    }
}
