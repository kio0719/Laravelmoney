<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserLoginRequest;
use Auth;

class UserController extends Controller
{
    public function getSignup(){
        return view('user.signup');
    }

    public function postSignup(UserRequest $request){
        //バリテーション    
 //       $this->validate($request,User::$rules,User::$messages);
        $user_registar = [
            'name' => $request->name,
            'email'=> $request -> email,
            'password'=>bcrypt($request->password),
        ];
        $request->session()->put('user_registar',$user_registar);
    //    $sesdata = $request->session()->get('asset_registar'); 
    // if($request->session()->has('asset_registar')){
    //        $item = 'ok' ; }else{
    //        $item= 'ng';
    //    };
    //    return view('user.check',['item'=>$asset_registar]);
        return redirect()->route('user.getcheck');
    }

    public function getcheck(Request $request){
        $sesdata = $request->session()->get('user_registar');

        if(!$sesdata){
            return redirect()->route('user.signup');
        }

        return view('user.check',['item'=>$sesdata]);
    }

    public function postcheck(Request $request){
    
            $sesdata = $request->session()->get('user_registar');
            if(!$sesdata){
                return redirect()->route('user.signup');
            }
            $user = new User([
                'name'=> $sesdata['name'],
                'email'=> $sesdata['email'],
                'password'=>$sesdata['password'],
            ]);

            $user->save();

            $request->session()->forget('user_registar');

            return redirect()->route('user.getrecomplate');
        }

   // public function getcomplate(Request $request){
   //     return view('user.complate');
   // }

   // public function postcomplate(Request $request){
    //    
    //    $rules = [
   //         'target_amount' => 'numeric | min:1',
    //        'deadline' => 'date'
    //    ];
    //    $param = [
    //        'target_amount' => $request->target_amount,
    //        'deadline' => $request->deadline
    //    ];
    //    $this->validate($request,$rules);
    //    DB::table('users')->where('id',$request->id)->update($param);
    //    return redirect('./user/recomplate');
    //}

    public function getrecomplate(){
        return view('user.recomplate');
    }

    public function getsignin(){
        return view('user.signin');
    }

    public function postsignin(UserLoginRequest $request){
    //    $this->validate($request,User::$rules,User::$messages);

        $email = $request->email;
        $password = $request->password;
        if(Auth::attempt(['email' => $email,'password'=>$password])){
            return redirect()->route('user.profile');
        //  return view('user.profile');
        }else{
            return redirect()->route('user.getfails');
         //   return view('user.fails');
        }
    }

    public function getprofile(){
        return view('user.profile');
    }

    public function getlogout(){
        Auth::logout();
        return view('user.signin');
    }

    public function getfails(){
        return view('user.fails');
    }
    
}
