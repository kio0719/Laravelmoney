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
        // $password=Hash::make($request->password);
        //   return view('login.confirm',['mail'=>$email,'password'=>$password]);
        $item = DB::table('members')->where('email',$email)->first();
        if(password_verify($request->password,$item->password)){
            $request->session()->put('join',$item);
            return redirect('/');
        //    return view('index',['item'=>$item]);
        }else{
            return view('login.fails');
        }
       
    }

    public function index(Request $request){
        $sesdata = $request->session()->get('join');
        if(empty($sesdata)){
            return view('login.fails');
        }
        return view('index',['session_data'=>$sesdata]);
    }

    public function logout(Request $request){
        $request->session()->forget('join');
        return view('login.logout');
    }
}
