<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Division;
use App\Models\Account;
use App\Http\Requests\AccountRequest;
use Illuminate\Support\Facades\Auth;

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
        $sort = $request->sort;
        if(!$sort){
            $sort='account_num';
        }
        $accounts = Account::where('member_id',Auth::id())->orderBy($sort,'asc')->simplePaginate(10);

        return view('account.account_list',['items' => $accounts]);
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
