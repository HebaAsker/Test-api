<?php

use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\Auth\WorkerAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


//public user routs
Route::post('/user_register',[UserAuthController::class,'register']);
Route::post('/user_login',[UserAuthController::class,'login']);

//protected user routs
Route::group(['middleware' => ['auth:sanctum']],function(){

    //user
    Route::get('/user',[UserAuthController::class,'show']);
    Route::post('/user_logout',[UserAuthController::class,'logout']);
});


//public worker routs
Route::post('/worker_register',[WorkerAuthController::class,'register']);
Route::post('/worker_login',[WorkerAuthController::class,'login']);

//protected worker routs
Route::group(['middleware' => ['auth:sanctum']],function(){

    //worker
    Route::get('/worker',[WorkerAuthController::class,'show']);
    Route::post('/worker_logout',[WorkerAuthController::class,'logout']);
});

