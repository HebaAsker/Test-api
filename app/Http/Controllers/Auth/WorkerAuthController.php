<?php

namespace App\Http\Controllers\Auth;

use App\Models\Worker;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class WorkerAuthController extends Controller
{
    //Register worker
    public function register(Request $request)
    {
        //validate
        $validation = $request->validate([
            'name'=>'required|string',
            'email'=>'required|email|unique:workers,email',
            'password'=>'required|min:8|confirmed',
            'phone'=>'required|string',
            'address'=>'required|string',
            'job'=>'required|string',
        ]);

        //create worker
        $worker=Worker::create([
            'name'=> $validation['name'],
            'email'=> $validation['email'],
            'password'=>bcrypt($validation['password']),
            'phone'=> $validation['phone'],
            'address'=> $validation['address'],
            'job'=> $validation['job'],
        ]);

        //return worker & token
        return response([
            'worker'=>$worker,
            'token'=>$worker->createToken('secret')->plainTextToken
        ]);
    }

    //Login worker
    public function login(Request $request)
    {
        //validate
        $validation = $request->validate([
            'email'=>'required|email',
            'password'=>'required|min:8',
        ]);
        //attempt login
        if(Worker::where('email',$validation['email'])->doesntExist())
        {
            return response(['message' =>'Invalid worker.'],403);
        }
        //return worker & token

        $worker=Worker::where('email',$validation['email'])->get();
        return response([
            'worker'=>$worker,
            // 'token'=>auth()->user()->createToken('secret')->plainTextToken
        ],200);
    }

    //logout
    public function logout()
    {
        $worker=Worker::where('email',['email'])->get();
        $worker->delete();
        return response(['message'=>'Logout success'],200);
    }

    //get worker details
    public function show()
    {
        return response(['worker'=>auth()->user()],200);
    }
}
