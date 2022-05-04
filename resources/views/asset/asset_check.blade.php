@extends('layouts.laravelmoney')

@section('title','資産登録')

@section('content')
 
<h2>以下の内容でよろしいでしょうか</h2>

<form action="./check" method="POST">
@csrf
<table>
    <tr>
    <th>資産番号</th>
    <td>{{$item['asset_num']}}</td>
    </tr>
    <tr>
    <th>資産の種類</th>
    <td>{{$asset_type->getAssetType()}}</td>
    </tr>
    <tr><th>資産名</th>
    <td>{{$item['asset_name']}}</td>
    </tr>
    <tr><th>残高</th>
    <td><p> {{$item['balance']}}</p></td></tr>
    <tr><th>備考</th>
    <td><p> {{$item['asset_note']}}</p></td></tr>
</table>
<input type="button" onclick="history.back()" value="戻る"> | <input type="submit" value="登録する">

</form>

@endsection