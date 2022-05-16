@extends('layouts.laravelmoney')

@section('title','勘定科目一覧')

@section('content')
<p><a href="{{route('account.getregistar')}}"><input type="button"value="勘定科目登録"></a></p>
<form action="{{route('account.postlist')}}" method="post" >
    @csrf
<ul>
    
    <li>収支区分：<select name="division_id">
    <option hidden></option>
    <option value="1">収入</option>
    <option value="2">支出</option>
    <option value="all">all</option>
</select></li>
<li>勘定科目番号：<input type="text" name="account_num"></li>
<li>勘定科目名：<input type="text" name="account_name"></li>
<li>備考：<input type="text" name="account_note"></li>

</ul>
<input type="submit" value="search">
</form>
<hr>
<p>{{$count}}件の検索結果</p>
<p>{{session('msg')}}</p><br>
<!--<form action="./check" method="POST">
@csrf-->
@if(!($items->isEmpty()))
<table>
    <tr>
        <th></th>
        <th><a href="{{route('account.getlist',[ 'sort' => 'account_num' ] ) }}">勘定科目番号</a></th>
        <th><a href="{{route('account.getlist',[ 'sort' => 'division_id' ] )}}">収支区分</a></th>
        <th><a href="{{route('account.getlist',[ 'sort' => 'account_name' ] )}}">勘定科目名</a></th>
        <th><a href="{{route('account.getlist',[ 'sort' => 'account_note' ] )}}">備考</a></th>
    </tr>
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
{{$items->links()}}


   @endif


<p><a href="{{route('user.profile')}}"><input type="button"value="戻る"></a></p>


<!--</form>-->

@endsection