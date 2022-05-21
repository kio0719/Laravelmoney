@extends('layouts.laravelmoney')

@section('title','勘定科目内容削除')

@section('content')

<p>この勘定科目を本当に削除しますか？</p>


<form action="./delete" method="POST">
@csrf
@foreach($items as $item)
<table>

    <tr><th>勘定科目番号</th><th>収支区分</th><th>勘定科目名</th><th>備考</th></tr>

    <tr><td>{{$item['account_num']}}</td><td>{{$item->Division->division_name}}</td><td>{{$item['account_name']}}</td><td>{{$item['account_note']}}</td></tr>



</table>
@endforeach
<input type="button" onclick="history.back()" value="戻る"> | <input type="submit" value="削除">

</form>

@endsection