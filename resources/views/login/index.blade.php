@extends('layouts.laravelmoney')

@section('title','会員ログイン')

@section('content')


<!--個々の部分コンポーネントにするといいかも -->
@if(count($errors)>0)
<p>入力に問題があります。再入力してください。</p>
@endif
<!-- -->

<form action="login" method="POST">
@csrf
<table>
    @error('mail')
    <tr><th>ERROR:</th><td>{{$message}}</td></tr>
    @enderror
    <tr><th>メールアドレス</th><td><input type="text" name="mail"></td></tr>
    @error('password')
    <tr><th>ERROR:</th><td>{{$message}}</td></tr>
    @enderror
    <tr><th>パスワード</th><td><input type="password" name="password"></td></tr>
</table>
<input type="submit" name="login">
<br>
<br>
<a href="join">会員登録がお済でない方はこちらから</a>

</form>

@endsection