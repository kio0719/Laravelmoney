<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class JoinController extends Controller
{
    public function login(){
        return view('login.index');
    }

    public function login_check(Request $request){
        //DBに接続してログイン処理
        $rules=[
            'mail'=>'email',
            'password'=>'alpha-num',
        ];

        $this->validate($request,$rules);

        $email=$request->mail;
        $password=Hash::make($request->password);
        return view('login.confirm',['mail'=>$email,'password'=>$password]);
        //$item = DB::table('members')->where('email',$email)->where('password',$password)->first();
        //if(empty($item)){
        //    return view('login.fails');
        //}
        //return view('login.complate',['item'=>$item]);
    }
}
