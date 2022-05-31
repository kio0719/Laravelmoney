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

        // if($request->has('detail')){
        //     return $this->getalllist($request);
        // }

        $method = $request->method(); 

        $log_as_find = $request->session()->get('log_as_find');

        if($method == "POST"){
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

             }elseif($method == "GET"){
                 if(isset($log_as_find)){
                    $asset_id = $log_as_find['asset_id'] ;
                    $dateb =$log_as_find['dateb'];
                    $datea = $log_as_find['datea'];
                 }else{
                    $asset_id = '' ;
                    $dateb ='';
                    $datea = '';
                 }
             }
             $request->session()->forget('log_as_find');

             $query = Log::where('member_id',Auth::id());


             if(!($asset_id == 'all')){
                $query->where('asset_id',$asset_id);
            }
            if(!empty($dateb) && !empty($datea)){
            $query->whereRaw('withdrawal_date >= ? and withdrawal_date <= ?',[$dateb,$datea]);
            }
            $logs=$query->sortable()->paginate(10);
           // $logs = Log::where('member_id',Auth::id())->where('asset_id',$asset_id)->whereRaw('withdrawal_date >= ? and withdrawal_date <= ?',[$dateb,$datea])->orderBy('log_id','asc')->Paginate(10);
                $count = count($logs);
        //     }


        // $logs = Log::where('member_id',Auth::id())->get();
         $assets = Asset::where('member_id',Auth::id())->get();

         // mergeをするとassetsのidが消されて0からの数字になってしまったので断念
    //      $all =array(0=>'all');

     //    $assets = array_merge_recursive($all,$assets);

         
        $request->session()->put('log_as_find',[
            'asset_id' =>$asset_id,
            'dateb' =>$dateb,
            'datea' =>$datea,
        ]);


        return view('log.log_aslist')->with([
            'items'=>$logs,
            'assets'=>$assets,
            'count'=>$count,
            'asset_id' =>$asset_id,
            'dateb'=>$dateb,
            'datea'=>$datea,
            'method'=>$method,
        ]);
        
    
    }

    
  
    

//     public function postasList(Request $request){
//         $asset_id = $request->asset_id;
//         $dateb = $request->dateb;
//         $datea = $request->datea;
//         if(!$dateb){
//             $dateb = Carbon::now();
//             $dateb = date_format($dateb,'Y-m-d');
//         }
//         if(!$datea){
//             $datea = Carbon::now();
//             $datea = date_format($datea,'Y-m-d');
            
//         }

//             if($asset_id == 'all'){
//             $logs = Log::where('member_id',Auth::id())->whereRaw('withdrawal_date >= ? and withdrawal_date <= ?',[$dateb,$datea])->orderBy('log_id','asc')->Paginate(10);
//            // $count = Log::where('member_id',Auth::id())->count();
//            $count = count($logs);
//         }else{
//         $logs = Log::where('member_id',Auth::id())->where('asset_id',$asset_id)->whereRaw('withdrawal_date >= ? and withdrawal_date <= ?',[$dateb,$datea])->orderBy('log_id','asc')->Paginate(10);
//            $count = count($logs);
//         }

//         if(!$count){
//             $count == 0;
//         }
//    //     $assets = Asset::where('member_id',Auth::id())->get();
//    $assets = Asset::where('member_id',Auth::id())->get()->pluck('asset_name','asset_id');

//         return view('log.log_aslist',['items'=>$logs,'assets'=>$assets,'count'=>$count,'dateb'=>$dateb,'datea'=>$datea]);
      
//     }
    //
    //
    //
    //atList
    //
    //
    //

    
    public function getatList(Request $request){
    //     $logs = collect([]);
    // //    $divisions = Division::all();
    //     $accounts = Account::where('member_id',Auth::id())->get();

    //     return view('log.log_atlist',['items'=>$logs,'accounts'=>$accounts,'count'=>'','dateb'=>' ','datea'=>' ']);



        //  if($request->has('detail')){
        //      return $this-> getdetail($request);
        //  }

        $method = $request->method(); 

        $log_at_find = $request->session()->get('log_at_find');

        if($method == "POST"){
            $account_id = $request->account_id;
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

             }elseif($method == "GET"){
                 if(isset($log_at_find)){
                    $account_id = $log_at_find['account_id'] ;
                    $dateb =$log_at_find['dateb'];
                    $datea = $log_at_find['datea'];
                 }else{
                    $account_id = '' ;
                    $dateb ='';
                    $datea = '';
                 }
             }
             $request->session()->forget('log_at_find');


             $query = Log::where('member_id',Auth::id());


             if(!($account_id == 'all')){
                $query->where('account_id',$account_id);
            }
            if(!empty($dateb) && !empty($datea)){
            $query->whereRaw('withdrawal_date >= ? and withdrawal_date <= ?',[$dateb,$datea]);
            }
            $logs=$query->sortable()->paginate(10);


        // $logs = Log::where('member_id',Auth::id())->get();
         $accounts = Account::where('member_id',Auth::id())->get();

         // mergeをするとassetsのidが消されて0からの数字になってしまったので断念
    //      $all =array(0=>'all');

     //    $assets = array_merge_recursive($all,$assets);


     $sum = 0;
     foreach($logs as $log){
         $sum = $sum + $log['amount'];
     }
         
        $request->session()->put('log_at_find',[
            'account_id' =>$account_id,
            'dateb' =>$dateb,
            'datea' =>$datea,
        ]);


        return view('log.log_atlist')->with([
            'items'=>$logs,
            'accounts'=>$accounts,
            'account_id' =>$account_id,
            'dateb'=>$dateb,
            'datea'=>$datea,
            'method'=>$method,
            'sum'=>$sum,
        ]);



        
    }

//     public function postatList(Request $request){

//     //　　収支区分
//     //    $division_id = $request->division_id;
//         $account_id = $request->account_id;
//     //    $keyword = $request->keyword;
//         $dateb = $request->dateb;
//         $datea = $request->datea;
//         if(!$dateb){
//             $dateb = Carbon::now();
//             $dateb = date_format($dateb,'Y-m-d');
//         }
//         if(!$datea){
//             $datea = Carbon::now();
//             $datea = date_format($datea,'Y-m-d');
            
//         }
//         //キーワード検索
//         // $accountnam_id = Account::select('account_id')->where('member_id',Auth::id())->where('account_name','like','%' . $keyword . '%')->get();
        

//         //     if($division_id == 'all'){
//         //     $logs = Log::where('member_id',Auth::id())->whereRaw('withdrawal_date >= ? and withdrawal_date <= ?',[$dateb,$datea])->where('account_id',$accountnam_id)->orWhere('log_note','like','%' . $keyword . '%')->orderBy('log_id','asc')->simplePaginate(10);
//         //    $count = count($logs);
//         // }else{
//         //     $accountdiv_id = Account::select('account_id')->where('member_id',Auth::id())->where('division_id',$division_id)->get();
//         //     $logs = Log::where('member_id',Auth::id())->where('account_id',$accountdiv_id)->whereRaw('withdrawal_date >= ? and withdrawal_date <= ?',[$dateb,$datea])->where('account_id',$account_id)->orWhere('log_note','like','%' . $keyword . '%')->orderBy('log_id','asc')->simplePaginate(10);
//         //    $count = count($logs);
//         // }

//         // if(!$count){
//         //     $count == 0;
//         // }

//          //   $query = Log::with(['account.division'])->where('division_id','=',$division_id);

//     //        $query = Division::with(['account.log']);
//             $query = Log::where('member_id',Auth::id())->whereRaw('withdrawal_date >= ? and withdrawal_date <= ?',[$dateb,$datea]);

//     if(!($account_id == 'all')){
//         $query->where('account_id','=',$account_id);
//     }
//  //   $query = Log::with(['account.division'])->where('account_id','=',$account_id);
//       //      if(!($division_id == 'all')){
//         //        $query->with(['account.division'])->where('division_id','=',$division_id);
//         //    }

        
//        $logs = $query->orderBy('log_id','asc')->simplePaginate(10);
//        $count = count($logs);
//        $sum = 0;
//        foreach($logs as $log){
//            $sum = $sum + $log['amount'];
//        }
// //      foreach($logs as $log)
// //      {$count = $log->getDivisionId();}

       
//        //検索機能継続のため
// //       $divisions = Division::all();
//        $accounts = Account::where('member_id',Auth::id())->get();

//         return view('log.log_atlist',['items'=>$logs,'accounts'=>$accounts,'count'=>$count,'sum'=>$sum,'dateb'=>$dateb,'datea'=>$datea]);
//     }
//
//
//
//alllist
//
//
//
    public function getallList(Request $request){

         $method = $request->method();

         $log_selects=$request->log_selects;

         $log_find = $request->session()->get('log_find');

        if($method == "POST"){
            $asset_id = $request->asset_id;
            $account_id = $request->account_id;
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


             }elseif($method == "GET"){
                 if(isset($log_find)){
                    $asset_id = $log_find['asset_id'] ;
                    $account_id = $log_find['account_id'];
                    $dateb =$log_find['dateb'];
                    $datea = $log_find['datea'];
                 }else{
                    $asset_id = '' ;
                    $account_id='';
                    $dateb ='';
                    $datea = '';
                 }
             }
             $request->session()->forget('log_find');

             $query= Log::where('member_id',Auth::id());




        if(!($asset_id == 'all')){
           $query->where('asset_id',$asset_id);
       }

       if(!($account_id == 'all')){
        $query->where('account_id','=',$account_id);
    }

       if(!empty($dateb) && !empty($datea)){
       $query->whereRaw('withdrawal_date >= ? and withdrawal_date <= ?',[$dateb,$datea]);
       }

       if(is_countable($log_selects)){
        $query = $query->where(function($query) use($log_selects){
            foreach($log_selects as $log_select){
            $query->orwhere('log_id',$log_select);
            }
        });
     }

       $logs=$query->sortable()->paginate(10);

       $accounts = Account::where('member_id',Auth::id())->get();
       $assets = Asset::where('member_id',Auth::id())->get();


       $request->session()->put('log_find',[
        'asset_id' =>$asset_id,
        'account_id' =>$account_id,
        'dateb' =>$dateb,
        'datea' =>$datea,
    ]);



        return view('log.log_alllist')->with([
            'items'=>$logs,
            'asset_id' =>$asset_id,
            'account_id' =>$account_id,
            'accounts'=>$accounts,
            'assets'=>$assets,
            'dateb'=>$dateb,
            'datea'=>$datea,
            'method'=>$method,

        ]);
    }

    //
    //
    //
    //detail
    //
    //
    //

    public function getdetail(Request $request){

        $log_select = $request->log_select;
        $url = $request->url();



        if($request->has('change')){
            return $this -> getChange($request);
         }
         if($request->has('delete')){
             return $this->getdelete($request);
         }


        // if($request->has('back')){
        //     $backUrl = $request->session()->get('log.back');
        //     $request->session()->forget('log.back');
        //     return redirect($backUrl);
        // }
        $query =  Log::where('member_id',Auth::id());
        if($log_select){
           $query = $query->where('log_id',$log_select);
            
        }else{
            return redirect($url)->with(['war_msg'=>'履歴が選択されていません。']);
        }

        $log = $query->first();

        if(!$log){
            return redirect($url)->with(['dng_msg'=>'エラーが発生しました。もう一度お試しください。']);
        }

    //    $request->session()->put('log.back',$url);
    //    return view('log.pra',['item' => $log]);
    $request->session()->put('log_select',$log_select);
    $request->session()->put('log_url',$url);
        return view('log.log_detail',['item' => $log]);

    }

    //
    //
    //
    //change
    //
    //
    //

    public function getChange(Request $request){

        $log_select = $request->session()->get('log_select');
        $log_url = $request->session()->get('log_url');

        $log =  Log::where('log_id',$log_select)->first();
        if(!$log){
           return redirect($log_url)->with(['dng_msg'=>'エラーが発生しました。もう一度お試しください。']);
 
        }

        $accounts = Account::all();
        $assets = Asset::all();
        $request->session()->put('log_change_select',$log_select);
        return view('log.log_change',['item' => $log,'accounts'=>$accounts,'assets'=>$assets]);
    //    return view('pra',['item' => $asset,'asset_types' => $asset_types]);

    }

    public function postChange(Request $request){
        $sessdata = $request->session()->get('log_select');
         $log_url   = $request->session()->get('log_url');
        if(!$sessdata){
            return redirect($log_url)->with(['dng_msg'=>'データが存在していません。']);
        }

        $log=Log::find($sessdata);


        //前のデータのAssetの項目取り出して前のデータ引いてから、

        $b_asset = Asset::find($log->Asset_id)->first();
        $account = Account::find($log->account_id)->first();
        $division = $account->getDivisionId();


        $b_amount = $log->amount;

        $b_balance = $b_asset->balance;
        if($division == 1){
        $b_balance = $b_balance - $b_amount;
        }else if($division == 2){
         $b_balance = $b_balance + $b_amount;
        }else{
            //redirect先変える
         return redirect($log_url)->with(['dng_msg'=>'データが存在していません。']);;
        }



        $b_asset->balance = $b_balance;
        $b_asset->save();

        //引落日以降のログ、消すログがない状態に書き換える

        $b_logs = Log::where('member_id',Auth::id())->where('withdrawal_date','>=',$log->withdrawal_date)->get();
        foreach($b_logs as $b_log){
            //収入なら引く、費用なら足す
            $b_log_balance = $b_log->asset_balance;
            if($division == 1){
            $b_log_balance = $b_log_balance - $b_amount;
            }else if($division == 2){
             $b_log_balance = $b_log_balance + $b_amount;
            }else{
                //redirect先変える
             return redirect($log_url)->with(['dng_msg'=>'データが存在していません。']);;
            }

            $b_log->asset_balance = $b_log_balance;
            $b_log->save();
        }
        /////////////

        //新しいデータのAsset取り出して新しいデータを足す
        $a_asset = Asset::find($request->asset_id)->first();
        $a_account = Account::find($request->account_id)->first();
        $a_division = $a_account->getDivisionId();

        
       $a_balance = $a_asset->balance;
       if($a_division == 1){
       $a_balance = $a_balance + $request->amount;
       }else if($a_division == 2){
        $a_balance = $a_balance - $request->amount;
       }else{
           //redirect先変える
    //    return redirect()->route('asset.getlist')->with(['msg'=>$division]);;
    return redirect($log_url)->with(['dng_msg'=>'データが存在していません。']);;

       }

       $a_asset->balance = $a_balance;
       $a_asset->save();

        //引落日以降のログ書き換える
        $a_logs = Log::where('member_id',Auth::id())->where('withdrawal_date','>=',$request->withdrawal_date)->get();
        foreach($a_logs as $a_log){
            //収入なら足す、費用なら引く
            $a_log_balance = $a_log->asset_balance;
            if($a_division == 1){
            $a_log_balance = $a_log_balance - $request->amount;
            }else if($a_division == 2){
             $a_log_balance = $a_log_balance + $request->amount;
            }else{
                //redirect先変える
           //  return redirect()->route('asset.getlist')->with(['msg'=>$division]);;
           return redirect($log_url)->with(['dng_msg'=>'データが存在していません。']);;

        }

            $a_log->asset_balance = $a_log_balance;
            $a_log->save();
        }

       /////////////


        $log->use_date = $request->input('use_date');
        $log->withdrawal_date = $request->input('withdrawal_date');
        $log->account_id = $request->input('account_id');
        $log->Asset_id = $request->input('asset_id');
        $log->amount = $request->input('amount');
        $log->log_note = $request->input('log_note');
         $log->asset_balance = $a_balance;

         $log->save();

        $request->session()->forget('log_select');
        $request->session()->forget('log_url');
        
        //routeパス記録しておく
        return redirect($log_url)->with(['flash_msg'=>'登録内容を変更しました']);;

 //        return redirect()->route('log.log_atlist')->with(['flash_msg'=>'登録内容を変更しました']);

         //新しいlogをつくって起票みたいに取り消し訂正つくるか、
         //今みたいに一緒のlogにするか
         //新しくlogを使った場合も引落日以降のbalance書き換える必要あり

         //Asset=使った金額になっている
         //redirect先が直前のdetailの画面、もうひとつ前のlog一覧にしたい

    }
}
