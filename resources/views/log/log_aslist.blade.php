@extends('layouts.laravelmoney')

@section('title','残高履歴')

@section('content')


<p>{{session('msg')}}</p><br>
<form action="{{route('log.postaslist')}}" method="POST">
@csrf
<p>資産</p><select name="asset_id">
@foreach($assets as $asset)
    <option value="{{$asset['asset_id']}}">{{$asset['asset_name']}}</option>
@endforeach
    <option value="all">すべて</option>
</select>
<input type="date" name="dateb" value="{{old('date1')}}">～<input type="date" name="datea" value="{{old('date2')}}">
<input type="submit" value="search">
</form>

<hr>


@if($count > 0)
<p>{{$dateb}} ~ {{$datea}}の検索結果</p>
<table>
    <tr>
        <th></th>
        <th>日付</th>
        <th>資産</th>
        <th>残高</th>
    </tr>
    @foreach($items as $item)
    <tr>
 <!--   <td><input type="radio" name="asset_select" value="{{$item['asset_id']}}"></td> 
-->
<td><a href="{{route('log.getdetail',['aslog_select' => $item['log_id'] ])}}"><input type="button" value="詳細"></a></td>     
        <td>{{$item['withdrawal_date']->format('Y-m-d')}}</td>
        <td>{{$item->asset->asset_name}}</td>
        <td>{{number_format($item['asset_balance'])}}円</td>
    </tr>
   @endforeach
</table>
<p>{{$count}}件の履歴がありました。</p>
{{$items->links()}}

<hr>

@elseif($count==0)
<p>{{$dateb}} ~ {{$datea}}の検索結果</p>
<p>{{$count}}件の履歴がありました。</p>
<hr>
@endif



<p><a href="{{route('user.profile')}}"><input type="button"value="戻る"></a></p>




@endsection