@extends('layouts.laravelmoney')



@section('content')



{{ Form::open(['route'=>'log.getatlist']) }}



<div class="row justify-content-start">
    <div class="col-md-2 mb-3">
        {{Form::label('account_id','科目名',['class'=>'form-label'])}}
        <div>
            <select name="account_id">
                <option value="all" @if($account_id == 'all') selected @endif>all</option>
                @foreach($accounts as $account)
                <option value="{{$account['account_id']}}" @if($account_id == $account['account_id']) selected @endif>{{$account['account_name']}}</option>
                @endforeach
      
            </select>
        </div>
    </div>

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
<p>{{$dateb}} ~ {{$datea}}の検索結果。</p>
<p>Total : {{number_format($sum)}} yen</p>

<div class="row mb-5">
<table class="table">
    <tr class="table-primary">
        <th></th>
        <th>@sortablelink('use_date','使用日')</th>
        <th>@sortablelink('account_id','収支区分')</th>
        <th>@sortablelink('account_id','勘定科目')</th>
        <th>@sortablelink('amount','金額')</th>
        <th>@sortablelink('log_note','備考')</th>
    </tr>
    @foreach($items as $item)
    <tr>
 <!--   <td><input type="radio" name="asset_select" value="{{$item['asset_id']}}"></td> 
-->

<td><a href="{{route('log.getdetail',['log_select'=>$item['log_id']])}}" class="btn btn-primary">detail</a></td>  
<td>{{$item['use_date']->format('Y-m-d')}}</td>
        <td>{{$item->getDivisionName()}}</td>
        <td>{{$item->account->account_name}}</td>
        <td>{{number_format($item['amount'])}}円</td>
        <td>{{$item['log_note']}}</td>
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