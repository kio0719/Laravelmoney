
@extends('layouts.laravelmoney')

@section('title','会員登録')

@section('content')

@if(count($errors)>0)
<p>入力に問題があります。再入力してください。</p>
@endif

<form action="signup" method="POST">
@csrf
<table>
    @error('name')
    <tr><th>ERROR:</th><td>{{$message}}</td></tr>
    @enderror
    <tr>
    <th>ニックネーム</th>
    <td><input type="text" name="name" value="{{old('name')}}"></td>
    </tr>
    @error('email')
    <tr><th>ERROR:</th><td>{{$message}}</td></tr>
    @enderror
    <tr><th>メールアドレス</th>
    <td><input type="text" name="email" value="{{old('email')}}"></td>
    </tr>
    @error('password')
    <tr><th>ERROR:</th><td>{{$message}}</td></tr>
    @enderror
    <tr><th>パスワード</th>
    <td><input type="password" name="password" value="{{old('password')}}"></td>
    </tr>
    <tr><th>パスワードをもう一度ご入力ください</th>
    <td><input type="password" name="password_confirmation"></td></tr>
    <tr><th></th><td><input type="submit" value="submit"></td></tr>
</table>

</form>

@endsection