<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assettype;
use App\Http\Requests\AssetRequest;
use App\Models\Asset;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator; 

class AssetController extends Controller
{
    public function getRegistar(Request $request){
        $asset_types= AssetType::all();
        return view('asset.asset_registar',['asset_types'=>$asset_types]);
    }

    public function postRegistar(AssetRequest $request){
        $asset_note = $request->asset_note;
        if(!$asset_note){
            $asset_note = '--';
        }
        $assetdata=[
            'asset_type_id'=>$request->asset_type_id,
            'asset_num'=>$request->asset_num,
            'asset_name'=>$request->asset_name,
            'balance'=>$request->balance,
            'asset_note' => $asset_note,
        ];


        $request->session()->put('assetdata',$assetdata);
        return redirect()->route('asset.getcheck');
   //     return view('asset.asset_check',['item'=>$request->all()]);
    }

    public function getcheck(Request $request){
        $sessdata = $request->session()->get('assetdata');
        if(!$sessdata){
            return redirect()->route('asset.getlist')->with(['dng_msg'=>'エラーが発生しました。もう一度お試しください。']);
        }

        $asset_type= AssetType::where('asset_type_id',$sessdata['asset_type_id'])->first();

        return view('asset.asset_check',['item'=>$sessdata,'asset_type'=>$asset_type]);
    }

    public function postCheck(Request $request){
        $sessdata = $request->session()->get('assetdata');
        if(!$sessdata){
            return redirect()->route('asset.getlist')->with(['dng_msg'=>'エラーが発生しました。もう一度お試しください。']);
        }
        $asset = new Asset([
            'member_id' => Auth::id(),
            'asset_num' => $sessdata['asset_num'],
            'asset_type_id' => $sessdata['asset_type_id'],
            'asset_name' => $sessdata['asset_name'],
            'balance' => $sessdata['balance'],
            'asset_note' => $sessdata['asset_note'],
        ]);

        $asset->save();

        $request->session()->forget('assetdata');

        return redirect()->route('asset.getlist')->with(['flash_msg'=>'資産を登録しました。']);
    }

    //
    //
    //
    //一覧
    //
    //
    //

    public function getlist(Request $request){
        // $sort=$request->sort;
        // if(!$sort){
        //     $sort='asset_num';
        // }
        if($request->has('change')){
           return $this -> getChange($request);
        }
        if($request->has('delete')){
            return $this->getdelete($request);
        }
        if($request->has('registar')){
            return $this->getregistar($request);
        }

        $method = $request->method();
  
        $as_find = $request->session()->get('as_find');
        if($method == "POST"){
       $asset_type_id = $request -> asset_type_id ;
       $asset_num = $request->asset_num;
       $asset_name = $request->asset_name;
       $balance = $request->balance;
       $asset_note = $request->aseet_note;
        }elseif($method == "GET"){
            if(isset($as_find)){
                $asset_type_id = $as_find['asset_type_id'] ;
                $asset_num =$as_find['asset_num'];
                $asset_name = $as_find['asset_name'];
                $balance = $as_find['balance'];
                $asset_note = $as_find['asset_note'];
            }else{
                $asset_type_id = 'all';
                $asset_num ='';
                $asset_name = '';
                $balance = '';
                $asset_note = '';
            }
        }
        $request->session()->forget('as_find');


        $query = Asset::where('member_id',Auth::id());

        if(!($asset_type_id == 'all')){
            $query->where('asset_type_id','like','%'. $asset_type_id . '%');
        }

        if(!empty($asset_num)){
            $query->where('asset_num','like','%'. $asset_num . '%');
        }

        if(!empty($asset_name)){
            $query->where('asset_name','like','%'. $asset_name . '%');
        }

        if(!empty($balance)){
            $query->where('balance','like','%'. $balance . '%');
        }

        if(!empty($sset_note)){
            $query->where('asset_note','like','%'. $asset_note . '%');
        }

        $assets= $query->sortable()->paginate(10);

        $request->session()->put('as_find',[
            'asset_type_id' => $asset_type_id,
            'asset_num' => $asset_num,
            'asset_name' => $asset_name,
            'balance' => $balance,
            'asset_note' => $asset_note,
        ]);

        $balance_sum = Asset::where('member_id',Auth::id())->sum('balance');
 
        return view('asset.asset_list')->with([
            'items' => $assets,
            'asset_type_id' => $asset_type_id,
            'asset_num' => $asset_num,
            'asset_name' => $asset_name,
            'balance' => $balance,
            'asset_note' => $asset_note,
            'balance_sum'=>$balance_sum
            ]);
    }

    //
    //
    //
    //変更
    //
    //
    //

    public function getChange(Request $request){
        $request->session()->forget('as_find');
        $asset_selects = $request->asset_selects;
        $query =  Asset::where('member_id',Auth::id());
        if(is_countable($asset_selects)){
           $query = $query->where(function($query) use($asset_selects){
                foreach($asset_selects as $asset_select){
                    $query->orwhere('asset_id',$asset_select);
                }
            });
        }else{
            return redirect()->route('asset.getlist')->with(['war_msg'=>'資産が選択されていません。']);
        }
       
        $assets =$query->get();
        if(!$assets){
            return redirect()->route('asset.getlist')->with(['dng_msg'=>'エラーが発生しました。もう一度お試しください。']);
        }
        $asset_types= AssetType::all();
        $request->session()->put('asset_change_selects',$asset_selects);
        return view('asset.asset_change',['items' => $assets,'asset_types'=>$asset_types]);
    //    return view('pra',['item' => $asset,'asset_types' => $asset_types]);

    }


    public function postChange(Request $request){
        $sessdatas = $request->session()->get('asset_change_selects');
        if(!$sessdatas){
            return redirect()->route('asset.getlist')->with(['dng_msg'=>'データが存在していません。']);
        }

        $i=0;
        foreach($sessdatas as $sessdata){
        $asset = Asset::find($sessdata);
       $asset->asset_num = $request->input('asset_num')[$i];
       $asset->asset_type_id = $request->input('asset_type_id')[$i];
       $asset->asset_name = $request->input('asset_name')[$i];
       $asset->balance = $request->input('balance')[$i];
       $asset->asset_note = $request->input('asset_note')[$i];

       $asset->save();
      $i++;
        }

    //    $asset->save();

        $request->session()->forget('asset_change_selects');

     //           return view('account.pra',['items'=>$sessdata]);
        return redirect()->route('asset.getlist')->with(['flash_msg'=>'登録内容を変更しました']);
    }

    public function getdelete(Request $request){
        $request->session()->forget('as_find');
        $asset_selects = $request->asset_selects;
        $query = Asset::where('member_id',Auth::id());
        if(is_countable($asset_selects)){
            $query = $query->where(function($query) use($asset_selects){
                foreach($asset_selects as $asset_select){
                    $query->orwhere('asset_id',$asset_select);
                    }
            });
        }else{
            return redirect()->route('asset.getlist')->with(['war_msg'=>'資産が選択されていません。']);
        }

        $assets = $query->get();

        if(!$assets){
            return redirect()->route('asset.getlist')->with(['dng_msg'=>'データが存在してません']);
            }
        $request->session()->put('asset_delete_data',$asset_selects);
        
        return view('asset.asset_delete',['items' => $assets]);
    }

    public function postdelete(Request $request){
        $sessdatas = $request->session()->get('asset_delete_data');

        if(!$sessdatas){
        return redirect()->route('asset.getlist')->with(['dng_msg'=>'データが存在してません']);;
        }
        foreach($sessdatas as $sessdata){
        Asset::find($sessdata)->delete();
        }
        $request->session()->forget('asset_delete_data');

        return redirect()->route('asset.getlist')->with(['flash_msg'=>'データを削除しました']);
    }
}

