@extends('layouts.laravelmoney')

@section('title','資産登録')

@section('content')


<!--個々の部分コンポーネントにするといいかも -->
@if(count($errors)>0)
<p>入力に問題があります。再入力してください。</p>
@endif
<!-- -->

<form action="./registar" method="POST">
@csrf
<table>
@error('use_date')
    <tr><th></th><td>{{$message}}</td></tr>
    @enderror
    <tr><th>使用日</th><td><input type="date" name="use_date"></td></tr>

    @error('withdrawal_date')
    <tr><th></th><td>{{$message}}</td></tr>
    @enderror
    <tr><th>引落日</th><td><input type="date" name="withdrawal_date"></td></tr>


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
    <tr><th>金額</th><td><input type="text" name="amount">円</td></tr>
 
    @error('log_note')
    <tr><th></th><td>{{$message}}</td></tr>
    @enderror
    <tr><th>備考</th><td><textarea name="log_note" cols="30" rows="10"></textarea></td></tr>

</table>
<input type="button" onclick="history.back()" value="戻る"> | <input type="submit" name="registar">

</form>

@endsection