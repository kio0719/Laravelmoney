<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MemberController extends Controller
{
    public function add(Request $request){
        return view('join.index');
    }

    public function check(Request $request){
        $rules=[
            'name'=>'required',
            'mail'=>'email',
            'password'=>'alpha-num | confirmed'
        ];
        //メッセージ変える
        //Errorの位置が少しおかしい。赤色に変える
        //エラー持ってたらエラー表示して再送
        //できればあとでModelを使ってのバリデーションに変更する
        $this->validate($request,$rules);

        return view('join.check',['item'=>$request->all()]);
    }

   public function recheck(Request $request){
        return view('join.check',['item'=>'']);
    }

    public function create(Request $request){
    //DBに追加する前に同じメールアドレスが登録されていないかチェック

    //    $member = new Member;
    //    $form = $request->all();
    //    unset($form['_token']);
    //    $member->fill($form)->save();
    $param = [
        'name'=> $request -> name,
        'email' => $request -> mail,
        'password'=>Hash::make($request->password),
    ];
    DB::table('members')->insert($param);
        return redirect('./join/complate');
    }

    public function complate(){
        return view('join.complate');
    }

    public function target_check(Request $request){

        $rules = [
            'target_amount' => 'numeric | min:1',
            'target_month' => 'date'
        ];
        $param = [
            'target_amount' => $request->target_amount,
            'target_month' => $request->target_month
        ];
        $this->validate($request,$rules);
        DB::table('members')->where('id',$request->id)->update($param);
        return redirect('./join/recomplate');
    }

    public function recomplate(){
        return view('join.recomplate');
    }
}
