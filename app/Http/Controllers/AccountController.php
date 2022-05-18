<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Division;
use App\Models\Account;
use App\Http\Requests\AccountRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator; 

class AccountController extends Controller
{
    //
    //
    //
    //登録処理
    //
    //
    //

    public function getRegistar(Request $request){
        $divisions= Division::all();
        return view('account.account_registar',['divisions'=>$divisions]);
    }

    public function postRegistar(AccountRequest $request){
        $account_note = $request->account_note;
        if(!$account_note){
            $account_note = '-';
        }
        $accountdata =[
            'account_num'=>$request->account_num,
            'account_name'=>$request->account_name,
            'division_id'=>$request->division_id,
            'account_note'=>$account_note,
        ];
        $request->session()->put('accountdata',$accountdata);

        return redirect()->route('account.getcheck');
    }

    public function getCheck(Request $request){
        $sessdata = $request->session()->get('accountdata');
        if(!$sessdata){
            return redirect()->route('account.getlist')->with(['msg'=>'エラーが発生しました。もう一度お試しください。']);
        }
        $division = Division::where('division_id',$sessdata['division_id'])->first();

            return view('account.account_check',['item'=>$sessdata,'division'=>$division]);
    }

    public function postCheck(Request $request){
        $sessdata = $request->session()->get('accountdata');
        if(!$sessdata){
            return redirect()->route('user.profile');
        }
        $account = new Account([
            'member_id'=>Auth::id(),
            'account_num'=>$sessdata['account_num'],
            'account_name'=>$sessdata['account_name'],
            'division_id'=>$sessdata['division_id'],
            'account_note'=>$sessdata['account_note'],
        ]);

        $account->save();

        $request->session()->forget('accountdata');

        return redirect()->route('account.getlist')->with(['msg'=>'勘定科目を登録しました']);
    }

    //
    //
    //
    //登録内容一覧
    //
    //
    //

    public function getlist(Request $request){
        // $sorttype = $request->sortype;
        // if(!$sorttype){
        //     $sorttype='account_num';
        // }


        
//         $accounts = Account::where('member_id',Auth::id())->orderBy($sort,'asc')->simplePaginate(10);
//     if($request->session()->has('account_list2')){
//         $query = $request->session()->get('account_list2');
//         $accounts = $query->orderBy($sort,'asc')->simplePaginate(10);;
//         $count = count($accounts);
//     }else{
//         $accounts=[];
//         $count='';
//     }

//$msg = count($accounts) . '件の検索結果;

    //     return view('account.account_list',['items' => $accounts,'count'=>$count]);
    //  }

    // //バリテーション
 //    public function postlist(Request $request){

        //session取り出す
         $method = $request->method();
         $at_find = $request->session()->get('at_find');
         if($method == "POST"){
        $division_id = $request -> division_id ;
        $account_num = $request->account_num;
        $account_name = $request->account_name;
        $account_note = $request->account_note;
         }elseif($method == "GET"){
             if(isset($at_find)){
            $division_id = $at_find['division_id'];
            $account_num = $at_find['account_num'];
            $account_name = $at_find['account_name'];
            $account_note = $at_find['account_note'];
             }else{
                 $division_id = 'all';
                 $account_num = '';
                 $account_name = '';
                 $account_note = '';
             }
         }
         $request->session()->forget('at_find');


        $query = Account::where('member_id',Auth::id());
        if(!($division_id == 'all')){
            $query->where('division_id','like','%'. $division_id . '%');
        }

        if(!empty($account_num)){
            $query->where('account_num','like','%'. $account_num . '%');
        }

        if(!empty($account_name)){
            $query->where('account_name','like','%'. $account_name . '%');
        }

        if(!empty($account_note)){
            $query->where('account_note','like','%'. $account_note . '%');
        }

   //    $accounts= $query->orderBy($sorttype,'asc')->paginate(3);
        $accounts= $query->sortable()->paginate(3);
   //    $total=$accounts->total();
     
       $count = count($accounts);

       $request->session()->put('at_find',[
           'division_id' => $division_id,
           'account_num' => $account_num,
           'account_name' => $account_name,
           'account_note' => $account_note,
       ]);

        return view('account.account_list')->with([
        'items' => $accounts,
        'count'=>$count,
        'division_id' => $division_id,
        'account_num' => $account_num,
        'account_name' => $account_name,
        'account_note' => $account_note,
        ]);
    }

    //
    //
    //
    //内容変更
    //
    //
    //

    public function getChange(Request $request,$account_select){
        $request->session()->put('account_select',$account_select);
        $account = Account::where('account_id',$account_select)->where('member_id',Auth::id())->first();
        if(!$account){
            return redirect()->route('account.getlist')->with(['msg'=>'エラーが発生しました。もう一度お試しください。']);
        }
        $divisions = Division::all();
        
        return view('account.account_change',['item'=>$account,'divisions'=>$divisions]);
    }

    public function postChange(Request $request){
        $sessdata = $request->session()->get('account_select');
        if(!$sessdata){
            return redirect()->route('account.getlist')->with(['msg'=>'エラーが発生しました。もう一度お試しください。']);
        }
        $account = Account::find($sessdata);
        $form = $request->all();
        unset($form['__token']);
        $account->fill($form)->save();

        $request->session()->forget('account_select');

        return redirect()->route('account.getlist')->with(['msg'=>'登録内容を変更しました。']);
    }
    
    //
    //
    //
    //削除
    //
    //
    //

    public function getDelete(Request $request,$account_select){
        $account = Account::where('account_id',$account_select)->where('member_id',Auth::id())->first();
        if(!$account){
            return redirect()->route('account.getlist')->with(['msg'=>'エラーが発生しました。もう一度お試しください。']);
        }
        $request->session()->put('account_delete_data',$account_select);

        return view('account.account_delete',['item'=>$account]);
    }

    public function postDelete(Request $request){
        $sessdata = $request->session()->get('account_delete_data');
        if(!$sessdata){
            return redirect()->route('account.getlist')->with(['msg'=>'エラーが発生しました。もう一度お試しください。']);
        }
        Account::find($sessdata)->delete();

        $request->session()->forget('account_delete_data');

        return redirect()->route('account.getlist')->with(['msg'=>'データを削除しました。']);
    }

}
