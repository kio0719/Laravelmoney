@extends('layouts.laravelmoney')

@section('title','資産一覧')

@section('content')


<p>{{session('msg')}}</p><br>
<!--<form action="./check" method="POST">
@csrf-->
@if(!($items->isEmpty()))
合計額:{{$balance_sum}} 円
<table>
    <tr>
        <th></th>
        <th><a href="{{route('asset.getlist',['sort'=>'asset_num'])}}">資産番号</a></th>
        <th><a href="{{route('asset.getlist',['sort'=>'asset_type_id'])}}">資産の種類</a></th>
        <th><a href="{{route('asset.getlist',['sort'=>'asset_name'])}}">資産名</a></th>
        <th><a href="{{route('asset.getlist',['sort'=>'asset_balance'])}}">残高</a></th>
        <th><a href="{{route('asset.getlist',['sort'=>'asset_note'])}}">備考</a></th>
    </tr>
    @foreach($items as $item)
    <tr>
 <!--   <td><input type="radio" name="asset_select" value="{{$item['asset_id']}}"></td> 
-->
<td><a href="{{route('asset.getchange',['asset_select' => $item['asset_id'] ])}}"><input type="button" value="変更する"></a> | 
<a href="{{route('asset.getdelete',['asset_select' => $item['asset_id'] ])}}"><input type="button" value="削除する"></a></td>     
        <td>{{$item['asset_num']}}</td>
        <td>{{$item->getAssetType()}}</td>
        <td>{{$item['asset_name']}}</td>
        <td>{{number_format($item['balance'])}}円</td>
        <td>{{$item['asset_note']}}</td>
    </tr>
   @endforeach
</table>
{{$items->links()}}
<p><a href="{{route('asset.getregistar')}}"><input type="button"value="資産登録"></a> </p>
@else
    <p>資産が登録されていません。</p>
    <p><a href="{{route('asset.getregistar')}}">資産登録を行う</a></p>
   @endif


<p><a href="{{route('user.profile')}}"><input type="button"value="戻る"></a></p>


<!--</form>-->

@endsection