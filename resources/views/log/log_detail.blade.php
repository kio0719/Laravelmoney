@extends('layouts.laravelmoney')


@section('content')

<div class="container-fluid">  





<div class="row mb-5 justify-content-center mt-5">
<table class="table col-10 table-bordered text-center">
    <tr class="text-center">
        <th class="table-primary" colspan="2">履歴詳細</th>
    </tr>
    <tr>
        <th>{{Form::label('use_date','使用日',['class'=>'form-label'])}}</th>
        <td>{{$item['use_date']->format('Y-m-d')}}</td> 
    </tr>
    <tr>
    <th>{{Form::label('withdrawal_date','引落日',['class'=>'form-label'])}}</th>
    <td>{{$item['withdrawal_date']->format('Y-m-d')}}</td>
    </tr>
    <tr>
    <th>{{Form::label('account_id','収支区分',['class'=>'form-label'])}}</th>
    <td>{{$item->getDivisionName()}}</td>
    </tr>
    <tr>
    <th>{{Form::label('account_id','勘定科目',['class'=>'form-label'])}}</th>
    <td>{{$item->account->account_name}}</td>
    </tr>
    <tr>
    <th>{{Form::label('amount','金額',['class'=>'form-label'])}}</th>
    <td>{{number_format($item['amount'])}}円</td>
    </tr>
    <tr>
    <th>{{Form::label('asset_name','資産',['class'=>'form-label'])}}</th>
    <td>{{$item->asset->asset_name}}</td>
    </tr>
    <tr>
    <th>{{Form::label('balance','残高',['class'=>'form-label'])}}</th>
    <td>{{number_format($item['asset_balance'])}}円</td>
    </tr>
    <tr>
    <th>{{Form::label('log_note','備考',['class'=>'form-label'])}}</th>
    <td>{{$item['log_note']}}</td>
    </tr>



</table>
</div>
{{ Form::open(['route'=>'log.getdetail']) }}
<div class="row justify-content-between">
    <div class="col-1  mb-3">
    <a class="btn btn-primary" href="javascript:history.back();">back</a>
    </div>
    <div class=" btn-group col-3">
        <input type="submit" name="change" value="change" class="col  btn btn-primary mb-3">
        <input type="submit" name="delete" value="delete" class="col btn btn-primary mb-3">        
    </div>
</div>


{{ Form::close() }}
</div>
@endsection