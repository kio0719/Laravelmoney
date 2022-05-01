<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Auth;

class UserController extends Controller
{
    public function getSignup(){
        return view('user.signup');
    }

    public function postSignup(Request $request){
        //バリテーション    
        $this->validate($request,User::$rules);
        return view('user.check',['item'=>$request->all()]);
    }

    public function getcheck(Request $request){
        return view('user.check',['item'=>'']);
    }

    public function postcheck(Request $request){
    
            $user = new User([
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>bcrypt($request->password),
            ]);

            $user->save();
            return redirect('./user/complate');
        }

    public function getcomplate(Request $request){
        return view('user.complate');
    }

    public function postcomplate(Request $request){
        
        $rules = [
            'target_amount' => 'numeric | min:1',
            'deadline' => 'date'
        ];
        $param = [
            'target_amount' => $request->target_amount,
            'deadline' => $request->deadline
        ];
        $this->validate($request,$rules);
        DB::table('users')->where('id',$request->id)->update($param);
        return redirect('./user/recomplate');
    }

    public function getrecomplate(){
        return view('user.recomplate');
    }

    public function getsignin(){
        return view('user.signin');
    }

    public function postsignin(Request $request){
        $this->validate($request,[
            'mail' => 'email | required',
            'password' => 'required | min:4'
        ]);

        $email = $request->mail;
        $password = $request->password;
        if(Auth::attempt(['email' => $email,'password'=>$password])){
            return view('user.profile');
        }else{
            return view('user.fails');
        }
    }

    public function getprofile(){
        return view('user.profile');
    }

    public function getlogout(){
        Auth::logout();
        return view('user.signin');
    }
    
}
