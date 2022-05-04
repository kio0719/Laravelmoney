<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assettype;
use App\Http\Requests\AssetRequest;
use App\Models\Asset;
use Illuminate\Support\Facades\Auth;

class AssetController extends Controller
{
    public function getRegistar(Request $request){
        $asset_types= AssetType::all();
        return view('asset.asset_registar',['asset_types'=>$asset_types]);
    }

    public function postRegistar(AssetRequest $request){
        $asset_note = $request->asset_note;
        if(!$asset_note){
            $asset_note = '特になし';
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

        $asset_type= AssetType::where('asset_type_id',$sessdata['asset_type_id'])->first();

        return view('asset.asset_check',['item'=>$sessdata,'asset_type'=>$asset_type]);
    }

    public function postCheck(Request $request){
        $sessdata = $request->session()->get('assetdata');
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

        return redirect()->route('asset.getcomplate');
    }

    public function getComplate(){
        return view('asset.asset_complate');
    }

    public function getlist(Request $request){
        $items = Asset::where('member_id',Auth::id())->orderBy('asset_num','asc')->get();
        $balance_sum = Asset::where('member_id',Auth::id())->sum('balance');
        $asset_types= AssetType::all();
        return view('asset.asset_list',['items'=>$items,'asset_types'=>$asset_types,'balance_sum'=>$balance_sum]);
    }

    public function getChange(Request $request,int $asset_select){
        $request->session()->put('asset_select',$asset_select);
        $asset = Asset::where('asset_id',$asset_select)->first();
        $asset_types= AssetType::all();
        return view('asset.asset_change',['item' => $asset,'asset_types'=>$asset_types]);
    //    return view('pra',['item' => $asset,'asset_types' => $asset_types]);

    }
    public function postChange(AssetRequest $request){
        $sessdata = $request->session()->get('asset_select');
        $asset = Asset::find($sessdata);
        $form = $request->all();
        unset($form['__token']);
        $asset->fill($form)->save();
    //    $asset = new Asset([
    //        'member_id' => Auth::id(),
    //        'asset_num' => $request->asset_num,
    //        'asset_type_id' => $request->asset_type_id,
    //        'asset_name' => $request->asset_name,
    //        'balance' => $request->balance,
    //        'asset_note' => $request->asset_note,
    //    ]);

    //    $asset->save();

        $request->session()->forget('asset_select');

        return redirect()->route('asset.getlist');
    }
}
