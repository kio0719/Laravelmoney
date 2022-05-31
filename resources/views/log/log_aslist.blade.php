@extends('layouts.laravelmoney')



@section('content')
<div class="container-fluid"> 
{{ Form::open(['route'=>'log.getaslist']) }}



<div class="row justify-content-start">
    <div class="col-md-2 mb-3">
        {{Form::label('asset_id','資産名',['class'=>'form-label'])}}
        <div>
            <select name="asset_id">
                <option value="all" @if($asset_id == 'all') selected @endif>all</option>
                @foreach($assets as $asset)
                <option value="{{$asset['asset_id']}}" @if($asset_id == $asset['asset_id']) selected @endif>{{$asset['asset_name']}}</option>
                @endforeach
      
            </select>
        </div>
    </div>

    <!--   <option value="all">すべて</option> -->
    <div class="col-md-9 mb-3" name="date">

    <div>日付範囲指定</div>
    <div class="row">
    <div class="col-md-4">
    {{Form::date('dateb', $dateb,['class'=>'form-control'])}}
    </div>
    <div class="col-md-1">
    ~
    </div>
    <div class="col-md-4">
    {{Form::date('datea', $datea,['class'=>'form-control'])}}
    </div>
    </div>
    </div>
    </div>
</div>

<div class="row justify-content-end">
{{Form::submit('search', ['name' => 'search', 'class' => 'btn btn-primary', 'onfocus' => 'this.blur();'])}}
</div>

<hr>


@if(session('flash_msg'))

<div class="alert alert-success " role="alert">
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
<p>{{$dateb}} ~ {{$datea}}の検索結果</p>
<div class="row mb-5">
<table class="table">
    <tr class="table-primary">
        <th></th>
        <th>@sortablelink('withdrawal_date','日付')</th>
        <th>@sortablelink('asset_name','資産')</th>
        <th>@sortablelink('balance','残高')</th>
    </tr>
    @foreach($items as $item)
    <tr>
 <!--   <td><input type="radio" name="asset_select" value="{{$item['asset_id']}}"></td> 
-->

        <td><a href="{{route('log.getdetail',['log_select'=>$item['log_id']])}}" class="btn btn-primary">detail</a></td>  
        <td>{{$item['withdrawal_date']->format('Y-m-d')}}</td>
        <td>{{$item->asset->asset_name}}</td>
        <td>{{number_format($item['asset_balance'])}}円</td>
    </tr>
   @endforeach
</table>
</div>
<p>{{$items->total()}}件の履歴がありました。</p>
<p>{{$items->links('vendor.pagination.default')}}</p>

<hr>

@elseif(($items->total() == 0) && $method == 'POST')
<p>{{$dateb}} ~ {{$datea}}の検索結果</p>
<p>該当する履歴が登録されていません。</p>
<hr>



@endif





{{ Form::close() }}
</div>
@endsection