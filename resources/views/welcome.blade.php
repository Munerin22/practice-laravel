@extends('layouts.menu')
@section('content')

<div class="container">
<div class="row">
<div class="col-md-8 col-md-offset-2">
<div class="panel panel-default">
<div class="panel-heading">Munehiroの学習部屋</div>
<div class="panel-body">

@foreach ($ports as $port)
★
<table class="table table-striped">
<tr>
<th><a href="{{$port['url']}}">{{$port['name']}}</a></th>
<th><img src="storage/{{$port['image']}}"  alt="画像データが見つかりません" height="auto" width="60%"></th>
</tr>

<!-- PFのレコード一覧表示 -->
<tr>
<td>Version：</td>
<td>{{$port['version']}}</td>
</tr>

<tr>
<td>機能①：</td>
<td>{{$port['function1']}}</td>
</tr>

<tr>
<td>機能②：</td>
<td>{{$port['function2']}}</td>
</tr>

<tr>
<td>テストユーザーMail：</td>
<td>{{$port['testmail']}}</td>
</tr>

<tr>
<td>テストユーザーPass：</td>
<td>{{$port['testpass']}}</td>
</tr>
</table>

<hr>
<p align="center">{{$port['comment']}}</p>
@endforeach

@endsection
