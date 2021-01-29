@extends('layouts.app')
@section('content')

<div class="container">
<div class="row">
<div class="col-md-8 col-md-offset-2">
<div class="panel panel-default">
<div class="panel-heading">カートに追加した商品</div>
<div class="panel-body">

@if (!$carts)
カートに何も入っていません
@else
<table border="1"align=center>
<tr>
<th>商品名</th>
<th>値段</th>
<th>購入数</th>
<th>小計</th>
</tr>
<!-- カート内の購入金額 -->
<?php $cost_all = 0 ?>
@foreach ($carts as $cart)
<!-- カートのレコード一覧表示 -->
<tr>
<td><a href="{{route('detail', ['id' => $cart['id']])}}">{{$cart['item']['name']}}</a></td>
<td>{{$cart['item']['price']}}円</td>
<td>{{$cart['count']}}個</td>
<!-- 小計を算出 -->
<?php $cost = $cart['item']['price'] * $cart['count'] ?>
<td>{{$cost}}円</td>
</tr>
<?php $cost_all = $cost + $cost_all ?>
@endforeach
</table>
合計金額：{{$cost_all}}円
@endif

@endsection
