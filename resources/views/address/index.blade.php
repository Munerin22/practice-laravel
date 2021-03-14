@extends('layouts.app')
@section('content')

<div class="container">
<div class="row">
<div class="col-md-8 col-md-offset-2">
<div class="panel panel-default">
<div class="panel-heading">お届け先 一覧</div>
<div class="panel-body">
@if (session('flash_message'))
<font color="#88bb99">{{session('flash_message')}}</font><br>
@endif

<div><a href="{{route('address.add.form')}}">新規登録</a>
<table class="table table-striped">
<tr>
<th>お名前</th>
<th>郵便番号</th>
<th>住所</th>
<th>連絡先</th>
<th>アクション<th>
</tr>

@foreach ($addressees as $address)
<!-- お届け先住所 一覧表示 -->
<tr>
<td>{{$address['name']}}</td>
<td>〒{{$address['post_number']}}</td>
<td>{{$address['prefecture']}} {{$address['city']}}<br>
{{$address['below_address']}}
<td>{{$address['phone']}}</td>
</td>
<td><a href="{{route('detail', ['id' => $address['id']])}}">編集</a>|
<a href="{{route('delete', ['id' => $address['id']])}}">削除</a>
</td>
</tr>
@endforeach
</table>

@endsection
