@extends('layouts.laravelmoney')

@section('title','会員登録')

@section('content')
 
<h2>以下の内容でよろしいでしょうか</h2>

<form action="./join/check" method="POST">
@csrf
<table>
    <tr>
    <th>ニックネーム</th>
    <td>{{$item['name']}}</td>
    <input type="hidden" name="name" value="{{$item['name']}}">
    </tr>
    <tr><th>メールアドレス</th>
    <td>{{$item['mail']}}</td>
    <input type="hidden" name="mail" value="{{$item['mail']}}">
    </tr>
    <tr><th>パスワード</th>
    <td><p>パスワードは表示されません</p></td></tr>
    <input type="hidden" name="password" value="{{$item['password']}}">
    <!--セッションでできるようにする-->
    <tr><td><input type="button" onclick="history.back()" value="戻る"></td><td><input type="submit" value="登録する"></td></tr>
</table>

</form>

@endsection