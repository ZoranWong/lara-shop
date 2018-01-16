@extends('layouts.box_base')
@include('layouts.vue_base')
@include('vendor.ueditor.head')
@section('box-title')
    新增商品
@stop
@section('box-body')
    <div id="app">
        <wxgood goods-id="{{ $id }}"></wxgood>
    </div>
@stop