@extends('layouts.laravelmoney')

@section('title','会員登録')

@section('content')
 
<h2>以下の内容でよろしいでしょうか</h2>

<form action="./check" method="POST">
@csrf
<table>
    <tr>
    <th>ニックネーム</th>
    <td>{{$item['name']}}</td>
    </tr>
    <tr><th>メールアドレス</th>
    <td>{{$item['email']}}</td>
    </tr>
    <tr><th>パスワード</th>
    <td><p>パスワードは表示されません</p></td></tr>
    <tr><td><input type="button" onclick="history.back()" value="戻る"></td><td><input type="submit" value="登録する"></td></tr>
</table>

</form>

@endsection