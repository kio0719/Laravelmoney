@extends('layouts.laravelmoney')

@section('title','勘定科目登録')

@section('content')


<!--個々の部分コンポーネントにするといいかも -->
@if(count($errors)>0)
<p>入力に問題があります。再入力してください。</p>
@endif
<!-- -->

<form action="./registar" method="POST">
@csrf
<table>
@error('account_num')
    <tr><th></th><td>{{$message}}</td></tr>
    @enderror
    <tr><th>勘定科目番号</th><td><input type="text" name="account_num"></td></tr>

    @error('division_id')
    <tr><th></th><td>{{$message}}</td></tr>
    @enderror
    <tr><th>収支区分</th>
    <td>
        <select name="division_id">
        @foreach($divisions as $division)
            <option value="{{$division->division_id}}">{{$division->getDivision()}}</option>
        @endforeach
        </select>
    </td></tr>

    @error('account_name')
    <tr><th></th><td>{{$message}}</td></tr>
    @enderror
    <tr><th>勘定科目名</th><td><input type="text" name="account_name"></td></tr>
   
 
    @error('account_note')
    <tr><th></th><td>{{$message}}</td></tr>
    @enderror
    <tr><th>備考</th><td><textarea name="account_note" cols="30" rows="10"></textarea></td></tr>

</table>
<input type="button" onclick="history.back()" value="戻る"> | <input type="submit" name="registar">

</form>

@endsection