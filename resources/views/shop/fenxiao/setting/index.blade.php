@extends('shop.fenxiao.layouts')
@section('tab_content')
        <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">

                    <li class="active"><a href="#basic" data-toggle="tab" aria-expanded="true">基本设置</a></li>
                    <li class=""><a href="#commission" data-toggle="tab" aria-expanded="false">佣金设置</a></li>
                    <li class=""><a href="#alone" data-toggle="tab" aria-expanded="false">商品独立佣金</a></li>
                    <li class=""><a href="#spread" data-toggle="tab" aria-expanded="false">分销说明</a></li>
                    <li class=""><a href="#cash" data-toggle="tab" aria-expanded="false">提现设置 </a></li>

                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="basic">
                        @include('shop.fenxiao.setting.basic.index')
                    </div>
                    <div class="tab-pane" id="commission">
                        @include('shop.fenxiao.setting.commission.index')
                    </div>
                    <div class="tab-pane" id="alone">
                        @include('shop.fenxiao.setting.alone.index')
                    </div>
                      <div class="tab-pane" id="spread">
                        @include('shop.fenxiao.setting.spread.index')
                    </div>  
                    <div class="tab-pane" id="cash">
                        @include('shop.fenxiao.setting.cash.index')
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
@stop
