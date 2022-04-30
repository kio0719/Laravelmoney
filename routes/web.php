<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\JoinController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {return view('welcome');});

Route::get('/',[JoinController::class,'index']);

Route::get('join',[Membercontroller::class,'add']);
Route::post('join',[MemberController::class,'check']);
Route::get('join/check',[MemberController::class,'recheck']);
Route::post('join/check',[MemberController::class,'create']);
Route::get('join/complate',[MemberController::class,'complate']);
Route::post('join/complate',[MemberController::class,'target_check']);
Route::get('join/recomplate',[MemberController::class,'recomplate']);


Route::get('login',[JoinController::class,'login']);
Route::post('login',[JoinController::class,'login_check']);
Route::get('login/logout',[JoinController::class,'logout']);
