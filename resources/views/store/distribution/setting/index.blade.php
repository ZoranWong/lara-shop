@extends('store.distribution.layouts')
@section('tab_content')
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li @if ($active == "basic") class="active" @endif><a href="/distribution/setting?store_id={{$store_id}}">基本设置</a></li>
                    <li @if ($active == "commission") class="active" @endif><a href="/distribution/setting/commission?store_id={{$store_id}}">佣金设置</a></li>
                    <li @if ($active == "cash") class="active" @endif><a href="/distribution/setting/cash?store_id={{$store_id}}">提现设置</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active">
                        @yield('setting_content')
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop