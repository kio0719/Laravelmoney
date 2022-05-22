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

    public function getRegistar(){
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
            return redirect()->route('account.getlist')->with(['msg'=>'エラーが発生しました。もう一度お試しください。']);
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

//     public function getlist(Request $request){
//         // $sorttype = $request->sortype;
//         // if(!$sorttype){
//         //     $sorttype='account_num';
//         // }


        
// //         $accounts = Account::where('member_id',Auth::id())->orderBy($sort,'asc')->simplePaginate(10);
// //     if($request->session()->has('account_list2')){
// //         $query = $request->session()->get('account_list2');
// //         $accounts = $query->orderBy($sort,'asc')->simplePaginate(10);;
// //         $count = count($accounts);
// //     }else{
// //         $accounts=[];
// //         $count='';
// //     }

// //$msg = count($accounts) . '件の検索結果;

//     //     return view('account.account_list',['items' => $accounts,'count'=>$count]);
//     //  }

//     // //バリテーション
//  //    public function postlist(Request $request){

//         //session取り出す
//          $method = $request->method();
//          $at_find = $request->session()->get('at_find');
//          if($method == "POST"){
//         $division_id = $request -> division_id ;
//         $account_num = $request->account_num;
//         $account_name = $request->account_name;
//         $account_note = $request->account_note;
//          }elseif($method == "GET"){
//              if(isset($at_find)){
//             $division_id = $at_find['division_id'];
//             $account_num = $at_find['account_num'];
//             $account_name = $at_find['account_name'];
//             $account_note = $at_find['account_note'];
//              }else{
//                  $division_id = 'all';
//                  $account_num = '';
//                  $account_name = '';
//                  $account_note = '';
//              }
//          }
//          $request->session()->forget('at_find');


//         $query = Account::where('member_id',Auth::id());
//         if(!($division_id == 'all')){
//             $query->where('division_id','like','%'. $division_id . '%');
//         }

//         if(!empty($account_num)){
//             $query->where('account_num','like','%'. $account_num . '%');
//         }

//         if(!empty($account_name)){
//             $query->where('account_name','like','%'. $account_name . '%');
//         }

//         if(!empty($account_note)){
//             $query->where('account_note','like','%'. $account_note . '%');
//         }

//    //    $accounts= $query->orderBy($sorttype,'asc')->paginate(3);
//         $accounts= $query->sortable()->paginate(3);
//    //    $total=$accounts->total();
     
//        $count = count($accounts);

//        $request->session()->put('at_find',[
//            'division_id' => $division_id,
//            'account_num' => $account_num,
//            'account_name' => $account_name,
//            'account_note' => $account_note,
//        ]);

//         return view('account.account_list')->with([
//         'items' => $accounts,
//         'count'=>$count,
//         'division_id' => $division_id,
//         'account_num' => $account_num,
//         'account_name' => $account_name,
//         'account_note' => $account_note,
//         ]);
//     }

    public function getlist(Request $request){
        if($request->has('change')){
        //    $account_select = $request->account_select;
       //     return redirect()->route('account.getchange')->with(compact('account_select'));
       return $this -> getChange($request);
    }
    if($request->has('delete')){
        return $this->getdelete($request);
    }
    if($request->has('registar')){
        return $this->getregistar();
    }

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


        $accounts= $query->sortable()->paginate(5);

     
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

    public function getChange(Request $request){
        $account_selects=$request->account_selects;

        $query = Account::where('member_id',Auth::id());
        if(is_countable($account_selects)){
        $query = $query -> where(function($query) use($account_selects){
            foreach($account_selects as $account_select){
                $query->orwhere('account_id',$account_select);
            }
        });
    }else{
        return redirect()->route('account.getlist')->with(['msg'=>'科目が選択されていません。']);       
    }
    $accounts = $query->get();
 //       $accounts = Account::where('account_id',$account_selects)->where('member_id',Auth::id())->first();
        
        if(!$accounts){
            return redirect()->route('account.getlist')->with(['msg'=>'エラーが発生しました。もう一度お試しください。']);
        }
        $divisions = Division::all();

        $request->session()->put('account_selects',$account_selects);
        
       return view('account.account_change',['items'=>$accounts,'divisions'=>$divisions]);
 //    return view('account.pra',['items'=>$accounts]);
    }

    public function postChange(Request $request){
        $sessdatas = $request->session()->get('account_selects');

        if(!$sessdatas){
            return redirect()->route('account.getlist')->with(['msg'=>'エラーが発生しました。もう一度お試しください。']);
        }
        $i=0;
        foreach($sessdatas as  $sessdata){
         $account = Account::find($sessdata);
        // $form = $request->all();
        // unset($form['__token']);
        // $account->fill($form)->save();
            $account->account_num = $request->input('account_num')[$i];
            $account->account_name = $request->input('account_name')[$i];
            $account->division_id = $request->input('division_id')[$i];
            $account->account_note = $request->input('account_note')[$i];


        $account->save();
        $i++;
        }

        $request->session()->forget('account_selects');

     //   return view('account.pra',['items'=>$sessdata]);
        return redirect()->route('account.getlist')->with(['msg'=>'登録内容を変更しました。']);
    }
    
    //
    //
    //
    //削除
    //
    //
    //

    public function getDelete(Request $request){
        $account_selects = $request->account_selects;
    //    $account = Account::where('account_id',$account_select)->where('member_id',Auth::id())->first();
        $query = Account::where('member_id',Auth::id());
        if(is_countable($account_selects)){
            $query = $query->where(function($query) use($account_selects){
                foreach($account_selects as $account_select){
                $query->orwhere('account_id',$account_select);
                }
            });
        }else{
            return redirect()->route('account.getlist')->with(['msg'=>'エラーが発生しました。もう一度お試しください。']);
        }
        $accounts = $query->get();

        if(!$accounts){
            return redirect()->route('account.getlist')->with(['msg'=>'エラーが発生しました。もう一度お試しください。']);
        }

        $request->session()->put('account_delete_datas',$account_selects);

        return view('account.account_delete',['items'=>$accounts]);
    }

    public function postDelete(Request $request){
        $sessdatas = $request->session()->get('account_delete_datas');
        if(!$sessdatas){
            return redirect()->route('account.getlist')->with(['msg'=>'エラーが発生しました。もう一度お試しください。']);
        }
        foreach($sessdatas as $sessdata){
        Account::find($sessdata)->delete();
        }

        $request->session()->forget('account_delete_datas');

        return redirect()->route('account.getlist')->with(['msg'=>'データを削除しました。']);
    }

}
