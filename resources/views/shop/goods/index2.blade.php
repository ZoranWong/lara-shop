@extends('layouts.my_page')
@section('content')
    <div class="row">
        <div class="col-xs-12" style="padding: 0;">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#selling" data-toggle="tab" aria-expanded="true">出售中</a></li>
                    <li class=""><a href="#saleout" data-toggle="tab" aria-expanded="false">已售罄</a></li>
                    <li class=""><a href="#stock" data-toggle="tab" aria-expanded="false">仓库中</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="selling">
                        @include('shop.goods.selling.index')
                    </div>
                    <div class="tab-pane" id="saleout">
                        @include('shop.goods.saleout.index')
                    </div>
                    <div class="tab-pane" id="stock">
                        @include('shop.goods.stock.index')
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop