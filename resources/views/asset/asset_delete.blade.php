@extends('layouts.laravelmoney')

@section('title','資産登録内容削除')

@section('content')

<p>この資産を本当に削除しますか？</p>

<!--個々の部分コンポーネントにするといいかも -->
@if(count($errors)>0)
<p>入力に問題があります。再入力してください。</p>
@endif
<!-- -->

<form action="./delete" method="POST">
@csrf
<table>

    <tr><th>資産番号</th><td>{{$item['asset_num']}}</td></tr>

    <tr><th>資産の種類</th><td>{{$item->assettype->asset_type_name}}</td></tr>


    <tr><th>資産名</th><td>{{$item['asset_name']}}</td></tr>
   

    <tr><th>残高</th><td>{{$item['balance']}} 円</td></tr>
 

    <tr><th>備考</th><td>{{$item['asset_note']}}</td></tr>

</table>
<input type="button" onclick="history.back()" value="戻る"> | <input type="submit" value="削除">

</form>

@endsection