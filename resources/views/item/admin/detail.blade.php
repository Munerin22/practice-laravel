@extends('layouts.admin')
@section('content')

<div class="container">
<div class="row">
<div class="col-md-8 col-md-offset-2">
<div class="panel panel-default">
<div class="panel-heading">商品情報</div>
<div class="panel-body">
<a href="{{route('admin.edit')}}">商品の編集</a>

<table border="1"align=center>
<tr>
<th>商品名</th>
<th>商品説明</th>
<th>値段</th>
<th>在庫の有無</th>
</tr>

<!-- 商品情報の表示 -->
<tr>
<td>{{$item_detail['name']}}</td>
<td>{{$item_detail['explain']}}</td>
<td>{{$item_detail['price']}}円</td>
@if ($item_detail['stock'] >= 1)
<td>在庫あり</td>
@else
<td>在庫無し</td>
@endif
</tr>
</table>

<a href="{{route('admin.index')}}">商品一覧</a>

@endsection
