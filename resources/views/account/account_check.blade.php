@extends('layouts.laravelmoney')

@section('title','資産登録')

@section('content')
 
<h2>以下の内容でよろしいでしょうか</h2>

<form action="./check" method="POST">
@csrf
<table>
    <tr>
    <th>勘定科目番号</th>
    <td>{{number_format($item['account_num'])}}</td>
    </tr>
    <tr>
    <th>収支区分</th>
    <td>{{$division->division_name}}</td>
    </tr>
    <tr><th>勘定科目名</th>
    <td>{{$item['account_name']}}</td>
    </tr>    
    <tr><th>備考</th>
    <td><p> {{$item['account_note']}}</p></td></tr>
</table>
<input type="button" onclick="history.back()" value="戻る"> | <input type="submit" value="登録する">

</form>

@endsection