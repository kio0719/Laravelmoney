@extends('layouts.laravelmoney')

@section('title','全体履歴')

@section('content')


<p>{{session('msg')}}</p><br>
<!--<form action="./check" method="POST">
@csrf-->
@if(!($items->isEmpty()))
<table>
    <tr><th></th><th>使用日</th><th>引落日</th><th>収支区分</th><th>勘定科目</th><th>金額</th><th>資産</th><th>残高</th><th>備考</th></tr>
    @foreach($items as $item)
    <tr>
 <!--   <td><input type="radio" name="asset_select" value="{{$item['asset_id']}}"></td> 
-->
<td><a href="{{route('log.getdetail',['alllog_select' => $item['log_id'] ])}}"><input type="button" value="詳細"></a></td> 
        <td>{{$item['use_date']}}</td>    
        <td>{{$item['withdrawal_date']}}</td>
        <td>{{$item->getDivisionName()}}</td>
        <td>{{$item->account->account_name}}</td>
        <td>{{number_format($item['amount'])}}円</td>
        <td>{{$item->asset->asset_name}}</td>
        <td>{{number_format($item['asset_balance'])}}円</td>
        <td>{{$item['log_note']}}</td>
    </tr>
   @endforeach
</table>
{{$items->links()}}
@else
    <p>履歴が登録されていません。</p>
   @endif


<p><a href="{{route('user.profile')}}"><input type="button"value="戻る"></a></p>


<!--</form>-->

@endsection