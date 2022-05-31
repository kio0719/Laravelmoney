@extends('layouts.laravelmoney')

@section('title','資産登録')

@section('content')

<div class="container-fluid">  
<!--個々の部分コンポーネントにするといいかも -->
@if(count($errors)>0)
<p>入力に問題があります。再入力してください。</p>
@endif
<!-- -->

{{ Form::open(['route'=>'log.postchange']) }}
<div class="row justify-content-center py-4">
<table class="table col-10">
    <tr class="table-primary"><th colspan="2" class="text-center">変更内容</th></tr>
@error('use_date')
    <tr><th></th><td>{{$message}}</td></tr>
    @enderror
    <tr><th>使用日</th><td><input type="date" name="use_date" value="{{$item['use_date']->format('Y-m-d')}}"></td></tr>

    @error('withdrawal_date')
    <tr><th></th><td>{{$message}}</td></tr>
    @enderror
    <tr><th>引落日</th><td><input type="date" name="withdrawal_date" value="{{$item['withdrawal_date']->format('Y-m-d')}}"></td></tr>


    @error('account_id')
    <tr><th></th><td>{{$message}}</td></tr>
    @enderror
    <tr><th>科目</th>
    <td>

    <!--科目の収支でoptgroup-->
        <select name="account_id">
        @foreach($accounts as $account)
            <option value="{{$account->account_id}}">{{$account->account_name}}</option>
        @endforeach
        </select>
    </td></tr>

    @error('asset_id')
    <tr><th></th><td>{{$message}}</td></tr>
    @enderror
    <tr><th>変更資産</th><td>
    <select name="asset_id">
        @foreach($assets as $asset)
            <option value="{{$asset->asset_id}}">{{$asset->asset_name}}</option>
        @endforeach
    </td></tr>
   
    @error('amount')
    <tr><th></th><td>{{$message}}</td></tr>
    @enderror
    <tr><th>金額</th><td><input type="text" name="amount" value="{{number_format($item['amount'])}}">円</td></tr>
 
    @error('log_note')
    <tr><th></th><td>{{$message}}</td></tr>
    @enderror
    <tr><th>備考</th><td><textarea name="log_note" cols="30" rows="10">{{$item['log_note']}}</textarea></td></tr>

</table>
</div>


<div class="row justify-content-between">
<div class="col-1">
    <a class="btn btn-primary" href="javascript:history.back();">back</a>
</div>
<div class="col-1">
        <input type="submit" name="change" value="change" class="col  btn btn-primary">
</div>

    </div>
</div>
{{ Form::close() }}

</div>

@endsection