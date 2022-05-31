@extends('layouts.laravelmoney')



@section('content')

<div class="container-fluid">  
<!--個々の部分コンポーネントにするといいかも -->
@if(count($errors)>0)
<p>入力に問題があります。再入力してください。</p>
@endif
<!-- -->

{{ Form::open(['route'=>'asset.postchange']) }}
<div class="row justify-content-center py-4">
@foreach($items as $item)
<table class="table col-10">
    <tr class="table-primary"><th colspan="2" class="text-center">変更内容</th></tr>
@error('asset_num')
    <tr><th></th><td>{{$message}}</td></tr>
    @enderror
    <tr><th>資産番号</th><td><input type="text" name="asset_num[]" value="{{$item['asset_num']}}"></td></tr>

    @error('asset_type_id')
    <tr><th></th><td>{{$message}}</td></tr>
    @enderror
    <tr><th>資産の種類</th>
    <td>
        <select name="asset_type_id[]">
        @foreach($asset_types as $asset_type)
            <option value="{{$asset_type->asset_type_id}}">{{$asset_type->getAssetType()}}</option>
        @endforeach
        </select>
    </td></tr>

    @error('asset_name')
    <tr><th></th><td>{{$message}}</td></tr>
    @enderror
    <tr><th>資産名</th><td><input type="text" name="asset_name[]" value="{{$item['asset_name']}}"></td></tr>
   
    @error('balance')
    <tr><th></th><td>{{$message}}</td></tr>
    @enderror
    <tr><th>残高</th><td><input type="text" name="balance[]"  value="{{$item['balance']}}">円</td></tr>
 
    @error('asset_note')
    <tr><th></th><td>{{$message}}</td></tr>
    @enderror
    <tr><th>備考</th><td><textarea name="asset_note[]" cols="30" rows="10">{{$item['asset_note']}}</textarea></td></tr>

</table>
</div>
@endforeach

<div class="row justify-content-end">
    <div class=" btn-group  mb-3">
    <a class="btn btn-primary" href="javascript:history.back();">back</a>
        <input type="submit" name="change" value="change" class="col  btn btn-primary">

    </div>
</div>
{{ Form::close() }}

</div>
@endsection