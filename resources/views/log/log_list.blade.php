@extends('layouts.laravelmoney')

@section('title','履歴')

@section('content')


<p>{{session('msg')}}</p><br>
<!--<form action="./check" method="POST">
@csrf-->
@if(!($items->isEmpty()))
<table>
    <tr><th></th><th>起票日</th><th>使用日</th><th>引落日</th><th>収支区分</th<th>勘定科目</th><th>金額</th>><th>変更資産</th><th>残高</th><th>備考</th></tr>
    @foreach($items as $item)
    <tr>
 <!--   <td><input type="radio" name="asset_select" value="{{$item['asset_id']}}"></td> 
-->
<td><a href="{{route('log.getchange',['log_select' => $item['log_id'] ])}}"><input type="button" value="変更する"></a> | 
<a href="{{route('log.getdelete',['log_select' => $item['log_id'] ])}}"><input type="button" value="削除する"></a></td>     
        <td>{{$item['updated_at']}}</td>
        <td>{{$item['use_date']}}</td>
        <td>{{$item['withdrawal_date']}}</td>
        <td>{{$item->getDivisionName()}}</td>
        <td>{{$item->account->account_name}}</td>
        <td>{{$item['amount']}}</td>
        <td>{{$item->asset->asset_name}}</td>
        <td>{{$item['asset_balance']}}</td>
        <td>{{$item['log_note']}}</td>
    </tr>
   @endforeach
</table>
<p><a href="{{route('log.getregistar')}}"><input type="button"value="資産登録"></a>
@else
    <p>収支履歴が登録されていません。</p>
    <p><a href="{{route('log.getregistar')}}">を行う</a></p>
   @endif


<p><a href="{{route('user.profile')}}"><input type="button"value="戻る"></a></p>


<!--</form>-->

@endsection