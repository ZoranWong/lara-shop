@extends('shop.fenxiao.layouts')
@section('tab_content')
    <div class="row"  style="margin: 0 auto;text-align: center;">
        <div class="tab-content">
            @include('shop.fenxiao.title.index')
        </div>
        <div class="col-md-12" style="margin: 0 auto;text-align: center;">
            @include('shop.fenxiao.title.orders')
        </div>
    </div>
    <style>
        .content-wrapper{
            background-color: rgba(255, 255, 255, 1);
        }
    </style>
@stop
