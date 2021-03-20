@extends('layouts.app')
@section('content')

<div class="container">
<div class="row">
<div class="col-md-8 col-md-offset-2">
<div class="panel panel-default">
<div class="panel-heading">お届け先の編集</div>
<div class="panel-body">
<a href="{{route('address.index')}}">お届け先 一覧</a>

<form method="POST" action="{{route('address.edit')}}">
{{ csrf_field() }}
<input type="hidden" name="id" value="{{ $address['id'] }}">

<ul>
@if ($errors->has('name'))
<li style="list-style:none"><font color="red">お届け先のお名前を入力してください</font></li>
@endif
<li><div>お名前：<input type="text" name="name" value="{{ $address['name'] }}"></div></li>
----------

@if ($errors->has('post_number'))
<li style="list-style:none"><font color="red">半角数字のみで入力してください</font></li>
@endif
<li><div>〒郵便番号：<input type="text" name="post_number" value="{{ $address['post_number'] }}"></div></li>
----------

@if ($errors->has('prefecture'))
<li style="list-style:none"><font color="red">都道府県名を入力してください</font></li>
@endif
<li><div>都道府県名：
<select name="prefecture" value="{{ $address['prefecture'] }}">
@foreach ($prefectures as $prefecture)
<option value="{{ $prefecture['name'] }}">{{ $prefecture['name'] }}</option>
@endforeach
</select>
</div></li>
----------

@if ($errors->has('city'))
<li style="list-style:none"><font color="red">市町村名を入力してください</font></li>
@endif
<li><div>市町村名：<input type="text" name="city" value="{{ $address['city'] }}"></div></li>
----------

@if ($errors->has('below_address'))
<li style="list-style:none"><font color="red">市町村以降を入力してください</font></li>
@endif
<li><div>市町村以降の住所：<input type="text" name="below_address" value="{{ $address['below_address'] }}"></div></li>
----------

@if ($errors->has('phone'))
<li style="list-style:none"><font color="red">半角数字のみで入力してください</font></li>
@endif
<li><div>電話番号：<input type="text" name="phone" value="{{ $address['phone'] }}"></div></li>
</ul>
<input type="submit" value="お届け先の住所を更新">
</form>

@endsection
