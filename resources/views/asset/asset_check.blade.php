@extends('layouts.laravelmoney')

@section('title','資産登録')

@section('content')
 
<h2>以下の内容でよろしいでしょうか</h2>

<form action="./check" method="POST">
@csrf
<table>
    <tr>
    <th>資産の種類</th>
    <td>{{$item['asset_type_id']}}</td>
    </tr>
    <tr><th>資産名</th>
    <td>{{$item['asset_name']}}</td>
    </tr>
    <tr><th>残高</th>
    <td><p> {{$item['balance']}}</p></td></tr>
    <tr><th>備考</th>
    <td><p> {{$item['note']}}</p></td></tr>
    <tr><td><input type="button" onclick="history.back()" value="戻る"></td><td><input type="submit" value="登録する"></td></tr>
</table>


</form>

@endsection