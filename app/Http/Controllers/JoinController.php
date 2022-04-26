<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JoinController extends Controller
{
    public function login(){
        return view('login.index');
    }

    public function login_check(Request $request){
        //DBに接続してログイン処理
        //Git使う
    }
}
