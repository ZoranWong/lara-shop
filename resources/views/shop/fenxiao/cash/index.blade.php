@extends('shop.fenxiao.layouts')
@section('tab_content')
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#audit" data-toggle="tab" aria-expanded="false">待审核</a></li>
                    {{--<li class=""><a href="#wait" data-toggle="tab" aria-expanded="true">待打款</a></li>--}}
                    <li class=""><a href="#tran" data-toggle="tab" aria-expanded="false">已打款</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="audit">
                        @include('shop.fenxiao.cash.audit')
                    </div>
                    {{--<div class="tab-pane" id="wait">--}}
                        {{--@include('my.home.shop.fenxiao.cash.waiting')--}}
                    {{--</div>--}}
                    <div class="tab-pane" id="tran">
                        @include('shop.fenxiao.cash.transfer')
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
