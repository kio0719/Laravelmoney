@extends('layouts.laravelmoney')

@section('title','会員トップページ')

@section('content')


<p>Welcome!</p>

<p>メニュー</p>
<ol>
<li><a href="#">家計簿</a></li>
<li><a href="#">資産</a></li>
    <ol>
        <li><a href="#">登録</a></li>
        <li><a href="#">一覧</a></li>
    </ol>
<li><a href="#">科目</a></li>
    <ol>
        <li><a href="#">登録</a></li>
        <li><a href="#">一覧</a></li>
    </ol>
<li><a href="#">入出金履歴</a></li>
</ol>
<!--   -->

<a href="./login/logout">ログアウト</a>




@endsection