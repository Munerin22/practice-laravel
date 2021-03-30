@extends('layouts.app')
@section('content')

<div class="container">
<div class="row">
<div class="col-md-8 col-md-offset-2">
<div class="panel panel-default">
<div class="panel-heading">お届け先の追加</div>
<div class="panel-body">
@if ($view == 'cart.send')
<a href="{{route('cart.send')}}">お届け先 一覧</a>
@else
<a href="{{route('address.index')}}">お届け先 一覧</a>
@endif

<form method="POST" action="{{route('address.add')}}">
{{ csrf_field() }}

<ul>
@if ($errors->has('name'))
<li style="list-style:none"><font color="red">お届け先のお名前を入力してください</font></li>
@endif
<li><div>お名前：<input type="text" name="name" value="{{ old('name') }}"></div></li>
----------

@if ($errors->has('post_number'))
<li style="list-style:none"><font color="red">半角数字のみで入力してください</font></li>
@endif
<li><div>〒郵便番号：<input type="text" name="post_number" value="{{ old('post_number') }}">※ハイフンなし（例）1237777</div></li>
----------

@if ($errors->has('prefecture'))
<li style="list-style:none"><font color="red">都道府県名を入力してください</font></li>
@endif
<li><div>都道府県名：
<select name="prefecture" value="{{ old('prefecture') }}">
@foreach ($prefectures as $prefecture)
<option value="{{ $prefecture['name'] }}">{{ $prefecture['name'] }}</option>
@endforeach
</select>
</div></li>
----------

@if ($errors->has('city'))
<li style="list-style:none"><font color="red">市町村名を入力してください</font></li>
@endif
<li><div>市町村名：<input type="text" name="city" value="{{ old('city') }}"></div></li>
----------

@if ($errors->has('below_address'))
<li style="list-style:none"><font color="red">市町村以降を入力してください</font></li>
@endif
<li><div>市町村以降の住所：<input type="text" name="below_address" value="{{ old('below_address') }}"></div></li>
----------

@if ($errors->has('phone'))
<li style="list-style:none"><font color="red">半角数字のみで入力してください</font></li>
@endif
<li><div>電話番号：<input type="text" name="phone" value="{{ old('phone') }}">※ハイフンなし（例）0120444777</div></li>
</ul>
<input type="hidden" name="url" value="{{ $view }}">
<input type="submit" value="お届け先の住所を追加">
</form>

@endsection
