@extends('store.distribution.layouts')
@section('tab_content')
    <style>
        .content-wrapper{background-color: rgba(255, 255, 255, 1);}
        .margin-lr{margin: 0 auto !important;text-align: center !important;}
    </style>
    <div class="row margin-lr"  >
        <div class="tab-content">
            @include('store.distribution.order.title.index')
        </div>
        <div class="col-md-12 margin-lr"  >
            @include('store.distribution.order.title.orders')
        </div>
    </div>
@stop