<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LogRequest;
use App\Models\Account;
use App\Models\Asset;
use App\Models\Log;
use Illuminate\Support\Facades\Auth;

class LogController extends Controller
{
    public function getRegistar(){
        $accounts = Account::all();
        $assets = Asset::all();
        return view('aslog.log_registar',['accounts'=>$accounts,'assets'=>$assets]);
    }

    public function postRegistar(LogRequest $request){
       $asset = Asset::find($request->asset_id)->where('member_id',Auth::id())->first();
       $account = Account::find($request->account_id)->where('member_id',Auth::id())->first();
       $division = $account->getDivisionId();


       $balance = $asset->balance;
       if($division == 1){
       $balance = $balance + $request->amount;
       }else if($division == 2){
        $balance =- $request->amount;
       }else{
           //redirect先変える
        return redirect()->route('asset.getlist')->with(['msg'=>$division]);;
       }

       
       $asset->balance = $balance;
       $asset->save();

       $log = new Log([
           'member_id' => Auth::id(),
           'use_date' => $request->use_date,
           'withdrawal_date' => $request->withdrawal_date,
           'account_id' => $request->account_id,
           'Asset_id' => $request->asset_id,
           'amount' => $request->amount,
            'log_note' => $request->log_note,
            'asset_balance' => $balance,
       ]);

       $log->save();

       return redirect()->route('user.profile');
       //->with(['msg'=>'登録しました。']);
    }

    public function getasList(Request $request){
        $logs = Log::where('member_id',Auth::id())->get();

        return view('log.log_aslist',['items'=>$logs]);
    }

    public function getatList(Request $request){
        $logs = Log::where('member_id',Auth::id())->get();

        return view('log.log_atlist',['items'=>$logs]);
    }
}
