<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LogRequest;
use App\Models\Account;
use App\Models\Asset;
use App\Models\Log;
use App\Models\Division;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class LogController extends Controller
{
    public function getRegistar(){
        $accounts = Account::all();
        $assets = Asset::all();
        return view('log.log_registar',['accounts'=>$accounts,'assets'=>$assets]);
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
    //
    //
    //
    //asList
    //
    //
    //

    public function getasList(Request $request){
        $logs = collect([]);
        $assets = Asset::where('member_id',Auth::id())->get();

        return view('log.log_aslist',['items'=>$logs,'assets'=>$assets,'count'=>'','dateb'=>' ','datea'=>' ']);
    }

    public function postasList(Request $request){
        $asset_id = $request->asset_id;
        $dateb = $request->dateb;
        $datea = $request->datea;
        if(!$dateb){
            $dateb = Carbon::now();
            $dateb = date_format($dateb,'Y-m-d');
        }
        if(!$datea){
            $datea = Carbon::now();
            $datea = date_format($datea,'Y-m-d');
            
        }

            if($asset_id == 'all'){
            $logs = Log::where('member_id',Auth::id())->whereRaw('withdrawal_date >= ? and withdrawal_date <= ?',[$dateb,$datea])->orderBy('log_id','asc')->simplePaginate(10);
           // $count = Log::where('member_id',Auth::id())->count();
           $count = count($logs);
        }else{
        $logs = Log::where('member_id',Auth::id())->where('asset_id',$asset_id)->whereRaw('withdrawal_date >= ? and withdrawal_date <= ?',[$dateb,$datea])->orderBy('log_id','asc')->simplePaginate(10);
           $count = count($logs);
        }

        if(!$count){
            $count == 0;
        }
        $assets = Asset::where('member_id',Auth::id())->get();

        return view('log.log_aslist',['items'=>$logs,'assets'=>$assets,'count'=>$count,'dateb'=>$dateb,'datea'=>$datea]);
      
    }
    //
    //
    //
    //atList
    //
    //
    //


    public function getatList(Request $request){
        $logs = collect([]);
    //    $divisions = Division::all();
        $accounts = Account::where('member_id',Auth::id())->get();

        return view('log.log_atlist',['items'=>$logs,'accounts'=>$accounts,'count'=>'','dateb'=>' ','datea'=>' ']);
    }

    public function postatList(Request $request){

    //　　収支区分
    //    $division_id = $request->division_id;
        $account_id = $request->account_id;
    //    $keyword = $request->keyword;
        $dateb = $request->dateb;
        $datea = $request->datea;
        if(!$dateb){
            $dateb = Carbon::now();
            $dateb = date_format($dateb,'Y-m-d');
        }
        if(!$datea){
            $datea = Carbon::now();
            $datea = date_format($datea,'Y-m-d');
            
        }
        //キーワード検索
        // $accountnam_id = Account::select('account_id')->where('member_id',Auth::id())->where('account_name','like','%' . $keyword . '%')->get();
        

        //     if($division_id == 'all'){
        //     $logs = Log::where('member_id',Auth::id())->whereRaw('withdrawal_date >= ? and withdrawal_date <= ?',[$dateb,$datea])->where('account_id',$accountnam_id)->orWhere('log_note','like','%' . $keyword . '%')->orderBy('log_id','asc')->simplePaginate(10);
        //    $count = count($logs);
        // }else{
        //     $accountdiv_id = Account::select('account_id')->where('member_id',Auth::id())->where('division_id',$division_id)->get();
        //     $logs = Log::where('member_id',Auth::id())->where('account_id',$accountdiv_id)->whereRaw('withdrawal_date >= ? and withdrawal_date <= ?',[$dateb,$datea])->where('account_id',$account_id)->orWhere('log_note','like','%' . $keyword . '%')->orderBy('log_id','asc')->simplePaginate(10);
        //    $count = count($logs);
        // }

        // if(!$count){
        //     $count == 0;
        // }

         //   $query = Log::with(['account.division'])->where('division_id','=',$division_id);

    //        $query = Division::with(['account.log']);
            $query = Log::where('member_id',Auth::id())->whereRaw('withdrawal_date >= ? and withdrawal_date <= ?',[$dateb,$datea]);

    if(!($account_id == 'all')){
        $query->where('account_id','=',$account_id);
    }
 //   $query = Log::with(['account.division'])->where('account_id','=',$account_id);
      //      if(!($division_id == 'all')){
        //        $query->with(['account.division'])->where('division_id','=',$division_id);
        //    }

        
       $logs = $query->orderBy('log_id','asc')->simplePaginate(10);
       $count = count($logs);
       $sum = 0;
       foreach($logs as $log){
           $sum = $sum + $log['amount'];
       }
//      foreach($logs as $log)
//      {$count = $log->getDivisionId();}

       
       //検索機能継続のため
//       $divisions = Division::all();
       $accounts = Account::where('member_id',Auth::id())->get();

        return view('log.log_atlist',['items'=>$logs,'accounts'=>$accounts,'count'=>$count,'sum'=>$sum,'dateb'=>$dateb,'datea'=>$datea]);
    }
//
//
//
//alllist
//
//
//
    public function getallList(Request $request){
        $logs = Log::where('member_id',Auth::id())->orderBy('log_id','asc')->simplePaginate(10);

        return view('log.log_alllist',['items'=>$logs]);
    }
}
