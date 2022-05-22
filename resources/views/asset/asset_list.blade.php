@extends('layouts.laravelmoney')

@section('title','Asset')

@section('content')
<div class="container-fluid">  
{{ Form::open(['route'=>'asset.getlist']) }}
<div class="row justify-content-end">
    <div class=" btn-group ">
        <input type="submit" name="registar" value="registar" class="col btn btn-primary mb-3">
        <input type="submit" name="change" value="change" class="col  btn btn-primary mb-3">
        <input type="submit" name="delete" value="delete" class="col btn btn-primary mb-3">
    </div>
</div>

<div class="row ">
    <div class="col-sm mb-3 ">
        {{Form::label('asset_type_id','資産種類',['class'=>'form-label'])}}
        {{Form::select('asset_type_id', ['1'=>'現金','2'=> '預金','all'=> 'all'],$asset_type_id,['class'=>'form-control'])}}
    </div>
    <div class="col-sm mb-3">
        {{Form::label('asset_num','資産番号',['class'=>'form-label'])}}
        {{Form::text('asset_num',$asset_num,['class'=>'form-control'])}}
    </div>

    <div class="col-sm mb-3">
        {{Form::label('asset_name','資産名',['class'=>'form-label'])}}
        {{Form::text('asset_name',$asset_name,['class'=>'form-control'])}}
    </div>
    <div class="col-sm mb-3">
        {{Form::label('balance','残高',['class'=>'form-label'])}}
        {{Form::text('balance',$balance,['class'=>'form-control'])}}
    </div>
    <div class="col-sm mb-3">
        {{Form::label('asset_note','備考',['class'=>'form-label'])}}
        {{Form::text('asset_note',$asset_note,['class'=>'form-control'])}}
    </div>

</div>
<div class="row justify-content-end">
        {{Form::submit('search', ['name' => 'search', 'class' => 'btn btn-primary', 'onfocus' => 'this.blur();'])}}
    </div>



<hr>
@if(session('flash_msg'))

<div class="alert alert-warning " role="alert">
{{session('flash_msg')}} 
    </button>

</div>
 @endif

 @if(session('dng_msg'))
    <div class="alert alert-danger d-flex align-items-center" role="alert"> 
    {{session('dng_msg')}}
</div>
 @endif

 
 @if(session('war_msg'))
    <div class="alert alert-warning d-flex align-items-center" role="alert"> 
    {{session('war_msg')}}
</div>
 @endif

@if($items->total() > 0)
合計額:{{number_format($balance_sum)}} 円
<div class="row mb-5">
<table class="table">
    <tr class="table-primary">
        <th></th>
        <th>@sortablelink('asset_num','資産番号')</th>
        <th>@sortablelink('asset_type_id','資産種類')</a></th>
        <th>@sortablelink('asset_name','資産名')</a></th>
        <th>@sortablelink('balance','残高')</a></th>
        <th>@sortablelink('asset_note','備考')</a></th>
    </tr>
    @foreach($items as $item)
    <tr>
 <!--   <td><input type="radio" name="asset_select" value="{{$item['asset_id']}}"></td> 
-->
<td ><div class="form-check"><input type="checkbox" name="asset_selects[]" value="{{$item['asset_id']}}" class="form-check-input"></div></td>
        <td>{{$item['asset_num']}}</td>
        <td>{{$item->getAssetType()}}</td>
        <td>{{$item['asset_name']}}</td>
        <td>{{number_format($item['balance'])}}円</td>
        <td>{{$item['asset_note']}}</td>
    </tr>
   @endforeach
</table>
</div>
<div class="row justify-content-center">
<p>{{$items->links('vendor.pagination.default')}}</p>
</div>
<hr>

@elseif(($items->total() == 0))
    <p>該当する資産が登録されていません。</p>
 @endif


 <div class="row justify-content-end">
<p><a href="{{route('user.profile')}}"><input type="button"value="戻る"></a></p>
</div>
{{ Form::close() }}

</div>


@endsection