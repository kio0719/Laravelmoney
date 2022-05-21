@extends('layouts.laravelmoney')

@section('title','勘定科目内容削除')

@section('content')

<p>この勘定科目を本当に削除しますか？</p>


<form action="./delete" method="POST">
@csrf
@foreach($items as $item)
<table>

    <tr><th>勘定科目番号</th><td>{{$item['account_num']}}</td></tr>

    <tr><th>収支区分</th><td>{{$item->Division->division_name}}</td></tr>


    <tr><th>勘定科目名</th><td>{{$item['account_name']}}</td></tr>
    

    <tr><th>備考</th><td>{{$item['account_note']}}</td></tr>

</table>
@endforeach
<input type="button" onclick="history.back()" value="戻る"> | <input type="submit" value="削除">

</form>

@endsection