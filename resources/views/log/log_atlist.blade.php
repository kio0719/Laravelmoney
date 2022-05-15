@extends('layouts.laravelmoney')

@section('title','入出金履歴')

@section('content')


<p>{{session('msg')}}</p><br>
<form action="{{route('log.postatlist')}}" method="POST">
@csrf
収支区分：<select name="division_id">
@foreach($divisions as $division)
    <option value="{{$division['division_id']}}">{{$division['division_name']}}</option>
@endforeach
    <option value="all">すべて</option>
</select>
キーワード：<input type="text" name="keyword" value="{{old('keyword')}}">
日付：<input type="date" name="dateb" value="{{old('dateb')}}">～<input type="date" name="datea" value="{{old('datea')}}">
<input type="submit" value="search">
</form>

<hr>


@if(!($items->isEmpty()))
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

@else
    <p>収支履歴が登録されていません。</p>
   @endif


<p><a href="{{route('user.profile')}}"><input type="button"value="戻る"></a></p>



@endsection