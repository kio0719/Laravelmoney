@extends('layouts.laravelmoney')

@section('title','勘定科目登録内容変更')

@section('content')


<!--個々の部分コンポーネントにするといいかも -->
@if(count($errors)>0)
<p>入力に問題があります。再入力してください。</p>
@endif
<!-- -->

<form action="./change" method="POST">
@csrf
@foreach($items as $item)
<table>
@error('account_num')
    <tr><th></th><td>{{$message}}</td></tr>
    @enderror
    <tr><th>資産番号</th><td><input type="text" name="account_num[]" value="{{$item['account_num']}}"></td></tr>

    @error('division_id')
    <tr><th></th><td>{{$message}}</td></tr>
    @enderror
    <tr><th>資産の種類</th>
    <td>
        <select name="division_id[]">
        @foreach($divisions as $division)
            <option value="{{$division->division_id}}">{{$division->division_name}}</option>
        @endforeach
        </select>
    </td></tr>

    @error('account_name')
    <tr><th></th><td>{{$message}}</td></tr>
    @enderror
    <tr><th>勘定科目名</th><td><input type="text" name="account_name[]" value="{{$item['account_name']}}"></td></tr>
   
   
    @error('account_note')
    <tr><th></th><td>{{$message}}</td></tr>
    @enderror
    <tr><th>備考</th><td><textarea name="account_note[]" cols="30" rows="10">{{$item['account_note']}}</textarea></td></tr>

</table>
@endforeach
<input type="button" onclick="history.back()" value="戻る"> | <input type="submit" name="変更する">

</form>

@endsection