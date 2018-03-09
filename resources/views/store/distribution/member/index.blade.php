@extends('store.distribution.layouts')
@section('tab_content')
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li @if ($active == "list") class="active" @endif >
                        <a href="/distribution/member?store_id={{$store_id}}">分销商</a>
                    </li>
                    <li @if ($active == "apply") class="active" @endif >
                        <a href="/distribution/member/apply?store_id={{$store_id}}">待审核</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active">
                       @yield('member_content')
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop