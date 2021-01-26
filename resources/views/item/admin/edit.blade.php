@extends('layouts.admin')
@section('content')

<div class="container">
<div class="row">
<div class="col-md-8 col-md-offset-2">
<div class="panel panel-default">
<div class="panel-heading">商品の編集</div>
<div class="panel-body">
<a href="{{route('admin.index')}}">商品一覧</a>

@if (count($errors) > 0)
<li style="list-style:none"><font color="red">==入力内容に不備があります==</font></li>
@endif

<form method="POST" action="item">
{{ csrf_field() }}
@if ($errors->has('id'))
<li style="list-style:none"><font color="red">不正なIDです</font></li>
@endif
<input type="hidden" name="id" value="{{$item_edit['id']}}">

<ul>
@if ($errors->has('name'))
<li style="list-style:none"><font color="red">存在しない商品名を入力してください</font></li>
@endif
<li><div>商品名：<input type="text" name="name" value="{{$item_edit['name']}}"></div></li>

@if ($errors->has('explain'))
<li style="list-style:none"><font color="red">1万文字以内で入力してください</font></li>
@endif
<li><div>説明：<textarea name="explain">{{$item_edit['explain']}}</textarea></div></li>

@if ($errors->has('stock'))
<li style="list-style:none"><font color="red">100万個以内(半角数字)で入力してください</font></li>
@endif
<li><div>在庫：<input type="text" name="stock"value="{{$item_edit['stock']}}">個</div></li>
</ul>
<input type="submit" value="更新">
</form>

@endsection
