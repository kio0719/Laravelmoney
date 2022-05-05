@extends('layouts.laravelmoney')

@section('title','勘定科目一覧')

@section('content')


<p>{{session('msg')}}</p><br>
<!--<form action="./check" method="POST">
@csrf-->
@if(!($items->isEmpty()))
<table>
    <tr><th></th><th>勘定科目番号</th><th>収支区分</th><th>勘定科目名</th><th>備考</th></tr>
    @foreach($items as $item)
    <tr>
 <!--   <td><input type="radio" name="asset_select" value="{{$item['asset_id']}}"></td> 
-->
<td><a href="{{route('account.getchange',['account_select' => $item['account_id'] ])}}"><input type="button" value="変更する"></a> | 
<a href="{{route('account.getdelete',['account_select' => $item['account_id'] ])}}"><input type="button" value="削除する"></a></td>     
        <td>{{$item['account_num']}}</td>
        <td>{{$item->getDivision()}}</td>
        <td>{{$item['account_name']}}</td>
        <td>{{$item['account_note']}}</td>
    </tr>
   @endforeach
</table>
<p><a href="{{route('account.getregistar')}}"><input type="button"value="資産登録"></a>
@else
    <p>資産が登録されていません。</p>
    <p><a href="{{route('account.getregistar')}}">勘定科目登録を行う</a></p>
   @endif


<p><a href="{{route('user.profile')}}"><input type="button"value="戻る"></a></p>


<!--</form>-->

@endsection