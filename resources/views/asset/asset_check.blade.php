@extends('layouts.laravelmoney')

@section('title','資産登録')

@section('content')
 
<h2>以下の内容でよろしいでしょうか</h2>

<form action="./check" method="POST">
@csrf
<table>
    <tr>
    <th>ニックネーム</th>
    <td>{{$item['name']}}</td>
    <input type="hidden" name="name" value="{{$item['name']}}">
    </tr>
    <tr><th>メールアドレス</th>
    <td>{{$item['email']}}</td>
    <input type="hidden" name="email" value="{{$item['email']}}">
    </tr>
    <tr><th>パスワード</th>
    <td><p>パスワードは表示されません</p></td></tr>
    <input type="hidden" name="password" value="{{$item['password']}}">
    <!--セッションでできるようにする-->
    <tr><td><input type="button" onclick="history.back()" value="戻る"></td><td><input type="submit" value="登録する"></td></tr>
</table>

</form>

@endsection