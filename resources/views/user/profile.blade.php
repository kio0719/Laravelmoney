@extends('layouts.laravelmoney')

@section('title','会員トップページ')

@section('content')


<p>Welcome!</p>

<p>メニュー</p>
<ol>
<li><a href="{{route('log.getregistar')}}">家計簿</a></li>
<li><a href="{{route('asset.getlist')}}">資産</a></li>
 <li><a href="{{route('account.getlist')}}">勘定科目 </a></li>
<li>履歴</li>
    <ol>
        <li><a href="{{route('log.getaslist')}}">資産残高履歴</a></li>
        <li><a href="{{route('log.getatlist')}}">入出金履歴</a></li>
        <li><a href="{{route('log.getalllist')}}">全体履歴</a>
    </ol>
</ol>
<!--   -->

<a href="{{route('user.getlogout')}}">ログアウト</a>




@endsection