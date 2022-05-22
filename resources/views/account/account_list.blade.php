@extends('layouts.laravelmoney')

@section('title','Account')

@section('content')
<div class="container-fluid">  
{{ Form::open(['route'=>'account.getlist']) }}
<div class="row justify-content-end">
<div class=" btn-group ">
<input type="submit" name="registar" value="registar" class="col btn btn-primary mb-3">
<input type="submit" name="change" value="change" class="col  btn btn-primary mb-3">
<input type="submit" name="delete" value="delete" class="col btn btn-primary mb-3">
</div>
</div>


 
<div class="row ">
    <div class="col-sm mb-3 ">
        {{Form::label('division_id','収支区分',['class'=>'form-label'])}}
        {{Form::select('division_id', ['1'=>'収入','2'=> '支出','all'=> 'all'],$division_id,['class'=>'form-control'])}}
    </div>
    <div class="col-sm mb-3">
        {{Form::label('account_num','勘定科目番号',['class'=>'form-label'])}}
        {{Form::text('account_num',$account_num,['class'=>'form-control'])}}
    </div>

    <div class="col-sm mb-3">
        {{Form::label('account_name','勘定科目名',['class'=>'form-label'])}}
        {{Form::text('account_name',$account_name,['class'=>'form-control'])}}
    </div>
    <div class="col-sm mb-3">
        {{Form::label('account_note','備考',['class'=>'form-label'])}}
        {{Form::text('account_note',$account_note,['class'=>'form-control'])}}
    </div>

</div>
<div class="row justify-content-end">
        {{Form::submit('search', ['name' => 'search', 'class' => 'btn btn-primary', 'onfocus' => 'this.blur();'])}}
    </div>



<hr>

<p>{{session('msg')}}</p><br>

@if($items->total() > 0)
<p>全{{$items->total()}}件</p>
<div class="row mb-5">
<table class="table">
    <tr class="table-primary">
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
<td ><div class="form-check"><input type="checkbox" name="account_selects[]" value="{{$item['account_id']}}" class="form-check-input"></div></td>   
        <td>{{$item['account_num']}}</td>
        <td>{{$item->getDivision()}}</td>
        <td>{{$item['account_name']}}</td>
        <td>{{$item['account_note']}}</td>
    </tr>
   @endforeach
</table>
</div>
<div class="row justify-content-center">
<p>{{$items->links('vendor.pagination.default')}}</p>
</div>
<hr>

@elseif(($items->total() == 0))
<p>該当する勘定科目が登録されていません。</p>
<hr>
@endif



<div class="row justify-content-end">
<p><a href="{{route('user.profile')}}"><input type="button"value="戻る"></a></p>
</div>
{{ Form::close() }}

</div>
@endsection