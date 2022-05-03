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
        $note = $request->note;
        if(!$note){
            $note = '特になし';
        }

        $assetdata=[
            'asset_type_id'=>$request->asset_type_id,
            'asset_name'=>$request->asset_name,
            'balance'=>$request->balance,
            'note' => $note,
        ];
        $request->session()->put('assetdata',$assetdata);
        return redirect()->route('asset.getcheck');
   //     return view('asset.asset_check',['item'=>$request->all()]);
    }

    public function getcheck(Request $request){
        $sessdata = $request->session()->get('assetdata');
        return view('asset.asset_check',['item'=>$sessdata]);
    }

    public function postCheck(Request $request){
        $sessdata = $request->session()->get('assetdata');
        $asset = new Asset([
            'member_id' => Auth::id(),
            'asset_type_id' => $sessdata['asset_type_id'],
            'asset_name' => $sessdata['asset_name'],
            'balance' => $sessdata['balance'],
            'note' => $sessdata['note'],
        ]);

        $asset->save();

        $request->session()->forget('assetdata');

        return redirect()->route('asset.getcomplate');
    }

    public function getComplate(){
        return view('asset.asset_complate');
    }
}
