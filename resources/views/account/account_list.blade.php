@extends('layouts.laravelmoney')

@section('title','勘定科目一覧')

@section('content')
<p><a href="{{route('account.getregistar')}}"><input type="button"value="勘定科目登録"></a></p>


{{ Form::open(['route'=>'account.getlist']) }}
    
<dl>

    <dt>{{Form::label('division_id','収支区分')}}</dt>
    <dd>
        {{Form::select('division_id', ['1'=>'収入','2'=> '支出','all'=> 'all'],$division_id)}}
    </dd>
<dt>{{Form::label('account_num','勘定科目番号')}}</dt>
<dd>{{Form::text('account_num',$account_num)}}</dd>
<dt>{{Form::label('account_name','勘定科目名')}}</dt>

<dd>{{Form::text('account_name',$account_name)}}
    
</dd>
<dt>{{Form::label('account_note','備考')}}</dt>
<dd>{{Form::text('account_note',$account_note)}}
{{Form::submit('search', ['name' => 'search', 'class' => 'btn btn-primary', 'onfocus' => 'this.blur();'])}}

</dd>
</dl>
{{ Form::close() }}
<hr>
<p>{{$count}}件の検索結果</p>
<p>{{session('msg')}}</p><br>
<!--<form action="./check" method="POST">
@csrf-->



<!--リスト表示-->
@if($count>0)
<table>
    <tr>
        <th></th>
        <th>@sortablelink('account_num','勘定科目番号')</th>
        <th>@sortablelink('division_id','収支区分')</a></th>
        <th>@sortablelink('account_name','勘定科目名')</a></th>
        <th>@sortablelink('account_note','備考')</a></th>
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
<article>
<p>{{$items->links('vendor.pagination.default')}}</p>
<p>全{{$items->lastpage()}}ページ中、{{$items -> currentPage()}}ページめを表示。全{{$items->total()}}件中@if($items -> firstItem() != $items -> lastItem() ) {{$items-> firstItem()}}件目から{{$items -> lastItem()}}件目まで表示 @else {{$items -> firstItem()}}件目を表示 @endif</p>


</article>


   @endif


<p><a href="{{route('user.profile')}}"><input type="button"value="戻る"></a></p>


<!--</form>-->

@endsection