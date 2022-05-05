@extends('layouts.laravelmoney')

@section('title','会員トップページ')

@section('content')


<p>Welcome!</p>

<p>メニュー</p>
<ol>
<li><a href="#">家計簿</a></li>
<li><a href="{{route('asset.getlist')}}">資産</a></li>
<li><a href="#">導入処理</a></li>
    <ol>
        <li><a href="{{route('account.getlist')}}">勘定科目</a></li>
        <li><a href="#">資産科目</a></li>
    </ol>
<li><a href="#">入出金履歴</a></li>
</ol>
<!--   -->

<a href="{{route('user.getlogout')}}">ログアウト</a>




@endsection