<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Division;
use App\Models\Account;
use App\Http\Requests\AccountRequest;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function getRegistar(Request $request){
        $divisions= Division::all();
        return view('account.account_registar',['divisions'=>$divisions]);
    }

    public function postRegistar(AccountRequest $request){
        $account_note = $request->account_note;
        if(!$account_note){
            $account_note = '特になし';
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
            return redirect()->route('user.profile');
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

        return redirect()->route('asset.getcomplate');
    }
}
