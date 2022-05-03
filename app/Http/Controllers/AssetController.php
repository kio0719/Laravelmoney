<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assettype;

class AssetController extends Controller
{
    public function getAssetRegistar(Request $request){
        $asset_types= AssetType::all();
        return view('asset.asset_registar',['asset_types'=>$asset_types]);
    }

    public function postAssetRegistar(Request $request){
        $this->validate($request,Asset::$rules);
        return view('asset.asset_check',['item'=>$request->all()]);
    }
}
