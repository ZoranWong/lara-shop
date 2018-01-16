@extends('shop.fenxiao.layouts')
@section('tab_content')
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#list" data-toggle="tab" aria-expanded="true">分销商</a></li>
                    <li class=""><a href="#apply" data-toggle="tab" aria-expanded="false">待审核</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="list">
                        @include('shop.fenxiao.member.list.index')
                    </div>
                    <div class="tab-pane" id="apply">
                        @include('shop.fenxiao.member.apply.index')
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
