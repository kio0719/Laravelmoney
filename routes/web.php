<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AssetController;

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

Route::get('/', function () {return view('welcome');});

//Route::get('/',[JoinController::class,'index']);

//Route::get('join',[Membercontroller::class,'add']);
//Route::post('join',[MemberController::class,'check']);
//Route::get('join/check',[MemberController::class,'recheck']);
//Route::post('join/check',[MemberController::class,'create']);
//Route::get('join/complate',[MemberController::class,'complate']);
//Route::post('join/complate',[MemberController::class,'target_check']);
//Route::get('join/recomplate',[MemberController::class,'recomplate']);

 //Route::group(['prefix'=>'user'],function(){
 //   Route::get('signup',[
   //     'uses'=>[UserController::class,'getSignup'],
    //    'as'=>'user.signup',
   // ]);
// });


//User
Route::group(['prefix'=>'user'],function(){

    Route::group(['middleware'=>'guest'],function(){
        Route::get('/signup',[UserController::class,'getSignup'])->name('user.signup');
        Route::post('/signup',[UserController::class,'postSignup'])->name('user.signup');
        Route::get('/check',[UserController::class,'getcheck']);
        Route::post('/check',[UserController::class,'postcheck']);
 //       Route::get('/complate',[UserController::class,'getcomplate']);
 //       Route::post('/complate',[UserController::class,'postcomplate']);
        Route::get('/recomplate',[UserController::class,'getrecomplate']);
        Route::get('/signin',[UserController::class,'getSignin'])->name('user.signin');
        Route::post('/signin',[UserController::class,'postSignin']);
    });
    Route::group(['middleware'=>'auth'],function(){
        Route::get('/profile',[UserController::class,'getProfile'])->name('user.profile');
        Route::get('/logout',[UserController::class,'getlogout'])->name('user.logout');
});

});



Route::group(['prefix'=>'asset'],function(){
    Route::get('/registar',[AssetController::class,'getAssetRegistar'])->name('asset.registar');
});


//signin
// Route::get('loginin',[JoinController::class,'login']);
//Route::post('loginin',[JoinController::class,'postAuth']);
//Route::get('loginin/logout',[JoinController::class,'logout']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

