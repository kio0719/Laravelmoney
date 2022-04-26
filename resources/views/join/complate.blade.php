@extends('layouts.laravelmoney')

@section('title','会員登録')

@section('content')

<P>会員登録が完了いたしました！</P>
<p>続いて目標額を設定しましょう！</p>
<form action="./complate" method="POST">
    @csrf
    <ul>
    <dl>
    <dt>ID</dt>
    <!-- セッションでID読み取れるようにしておく -->
    <dd><input type="text" name="id" value="{{old('id')}}"></dd>    
    <dt><p>目標額</p></dt>
    @error('target_amount')
    <p>ERROR : {{$message}} </p>
    @enderror
    <dd><input type="text" name="target_amount" value="{{old('target_amount')}}">円</dd>
    <dt><p>いつまでに？</p></dt>
    @error('target_month')
    <p>ERROR : {{$message}}</p>
    @enderror
    <dd><input type="date" name="target_month" value="{{old('target_month')}}"></dd>
    </dl>
    <input type="submit" value ="registar">
    </ul>
</form>


@endsection