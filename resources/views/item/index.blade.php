@extends('layouts.app')
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
</head>
<body>
@section('content')
<div class="container">
<div class="row">
<div class="col-md-8 col-md-offset-2">
<div class="panel panel-default">
<div class="panel-heading">商品一覧</div>
<div class="panel-body">

<table border="1"align=center>
<tr>
<th>商品名</th>
<th>値段</th>
<th>在庫の有無</th>
</tr>

@foreach ($items as $item)
<!-- 商品のレコード一覧表示 -->
<tr>
<td>{{$item['name']}}</td>
<td>{{$item['price']}}円</td>
@if ($item['stock'] >= 1)
<td>在庫あり</td>
@else
<td>在庫無し</td>
@endif
</tr>
@endforeach
</table>

@endsection
</body>
</html>
