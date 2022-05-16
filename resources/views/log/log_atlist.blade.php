@extends('layouts.laravelmoney')

@section('title','入出金履歴')

@section('content')


<p>{{session('msg')}}</p><br>
<form action="{{route('log.postatlist')}}" method="POST">
@csrf



科目：
<select name="account_id">
@foreach($accounts as $account)
    <option value="{{$account['account_id']}}">{{$account['account_name']}}</option>
@endforeach
    <option value="all">すべて</option>
</select>

日付：<input type="date" name="dateb" value="{{old('dateb')}}">～<input type="date" name="datea" value="{{old('datea')}}">
<input type="submit" value="search">
</form>

<hr>


@if($count > 0)
<p>{{$dateb}} ~ {{$datea}}の検索結果。{{$count}}件の履歴がありました。</p>
<p>Total : {{number_format($sum)}} yen</p>

<table>
    <tr><th></th><th>使用日</th><th>収支区分</th><th>勘定科目</th><th>金額</th><th>備考</th></tr>
    @foreach($items as $item)
    <tr>
 <!--   <td><input type="radio" name="asset_select" value="{{$item['asset_id']}}"></td> 
-->
<td><a href="{{route('log.getdetail',['atlog_select' => $item['log_id'] ])}}"><input type="button" value="詳細"></a></td>
        <td>{{$item['use_date']->format('Y-m-d')}}</td>
        <td>{{$item->getDivisionName()}}</td>
        <td>{{$item->account->account_name}}</td>
        <td>{{number_format($item['amount'])}}円</td>
        <td>{{$item['log_note']}}</td>
    </tr>
   @endforeach
</table>

{{$items->links()}}

@elseif($count == 0)
<p>{{$dateb}} ~ {{$datea}}の検索結果。{{$count}}件の履歴がありました。</p>
<hr>
@endif


<p><a href="{{route('user.profile')}}"><input type="button"value="戻る"></a></p>



@endsection