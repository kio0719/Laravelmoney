@extends('layouts.laravelmoney')

@section('title','会員ログイン')

@section('content')


<!--個々の部分コンポーネントにするといいかも -->
@if(count($errors)>0)
<p>入力に問題があります。再入力してください。</p>
@endif
<!-- -->

<form action="signin" method="POST">
@csrf
<table>
    @error('email')
    <tr class="errorMessage"><th></th><td>{{$message}}</td></tr>
    @enderror
    <tr><th>メールアドレス</th><td><input type="text" name="email"></td></tr>
    @error('password')
    <tr class="errorMessage"><th></th><td>{{$message}}</td></tr>
    @enderror
    <tr><th>パスワード</th><td><input type="password" name="password"></td></tr>
    <tr><th></th><td><input type="submit" name="login"></td></tr>
</table>

<br>
<br>
<a href="{{route('user.signup')}}">会員登録がお済でない方はこちらから</a>

</form>

@endsection