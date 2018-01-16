@extends('layouts.my_page')

@section('content')
    <style>
        .box{margin-bottom: 0px;border-top:0px;border-radius: 0;}
        .opt-title{
                font-size: 14px;
                padding: 8px;
                margin: 8px 1.5%;
                background-color: #efefef;
            }
        .form-box{
              margin: 8px 1.5%;
        }
        .nav-tabs-custom .nav.nav-tabs li a{
            font-size: 14px;
        }
        .required:before {
            content: '*';
            font-size: 14px;
            color: #e01212;
        }

        .form-horizontal .control-label{
            font-size: 14px;
            font-weight: 400;
        }
        .tips{
            font-size: 12px;
            color: #9a9a9a;
        }
        .tip-warning{
            color: red;
        }

        .ver-line{
            height: auto;
            width: 1px;
            margin: -10px 36px;
            position: relative;
        }
        .ver-line:after {
            content: '';
            background: #bfbfbf;
            width: 35%;
            height: 100%;
            position: absolute;
        }
        .groupon-activity-price ul li{
            display: flex;
        }
        .groupon-activity-price ul li label{
            text-align: left;
        }
        .groupon-activity-price ul li label.title{
            width: 98px;
        }

        .form-group.has-error .goods {
            border-color: #dd4b39;
        }

        .form-group label.has-error {
            color: #dd4b39;
        }

        .form-group input.has-error {
            border-color: #dd4b39;
        }
        .start-datepicker-1 , .end-datepicker-1{
            position: absolute;
            z-index:-100;
            top:0;
            left:0;
            width: 100%;
        }

        .bootstrap-table{
            min-height: 390px;
        }
        .pagination-hide{
            display: none !important;
        }
        .pagination-show{
            display: block !important;
        }

    </style>
    <div class="row">
        <div class="col-md-12">
            <div class="box-header with-border col-md-8">
                <h3 class="box-title">多人拼团</h3>
                <p class = "groupon-intr " style="margin-top: 6px; margin-bottom: 6px; font-size: 13px; color: #5a5a5a;">
                    多人拼团是醉赞商城推出的一款付费营销应用，活动基于多人组团形式，鼓励买家发起拼团，邀请好友以后折扣价格购买优质商品，
                    同时给店铺带来更好的传播效果。
                </p>
               {{-- <p style="margin-top: 6px; margin-bottom: 6px; font-size: 13px; color: #9a9a9a;">拼团服务专线：XXXX-XXXXXXXX，服务时间：10：00-18：00</p>--}}
                {{--<p style="margin-top: 6px; margin-bottom: 12px; font-size: 13px;">--}}
                    {{--<a href="#">应用详情</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#">使用教程</a>--}}
                {{--</p>--}}
            </div>
        </div>
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active" data-status = "all" ><a href="#all" data-toggle="tab" aria-expanded="true">全部</a></li>
                    <li class="" data-status = "not_start" ><a href="#not_start" data-toggle="tab" aria-expanded="false">未开始</a></li>
                    <li class="" data-status = "running" ><a href="#running" data-toggle="tab"   aria-expanded="false">进行中</a></li>
                    <li class="" data-status = "end" ><a href="#end" data-toggle="tab" aria-expanded="false">已结束</a></li>
                    {{--<a style="position: absolute;right: 43px;top: 13px;font-size: 12px;" href="#add" data-toggle="tab" aria-expanded="false">--}}
                        {{--查看【多人拼团】使用教程--}}
                    {{--</a>--}}

                </ul>
                <div class = "create-groupon-activity" style="display: none ;position: absolute;z-index: 10; top: 64px;">
                    <div class = "col-md-5" >
                        <button type="button create-btn" style = "margin: 12px 0 12px 24px;" class="btn btn-success">新建拼团活动</button>
                    </div>
                </div>
                <div class="tab-content">
                    <div class="tab-pane active" id="all">
                        @include('shop.grouponActivity.tables.all.index')
                    </div>
                    <div class="tab-pane " id="not_start">
                        @include('shop.grouponActivity.tables.notstart.index')
                    </div>
                    <div class="tab-pane " id="running">
                        @include('shop.grouponActivity.tables.running.index')
                    </div>
                    <div class="tab-pane " id="end">
                        @include('shop.grouponActivity.tables.end.index')
                    </div>
                    <div class="tab-pane " id="add">
                        @include('shop.grouponActivity.add.add')
                    </div>
                    <div class="tab-pane " id="edit">
                        @include('shop.grouponActivity.edit.edit')
                    </div>
                    <div class="tab-pane " id="detail">
                        @include('shop.grouponActivity.detail.detail')
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@include('shop.grouponActivity.common.commonJs')
@include('shop.grouponActivity.common.httpUtil')
@include('shop.grouponActivity.templates.spread')
@include('shop.grouponActivity.templates.goodslist')
@section('js')
<script>
    $(document).ready(function () {
        navTabsInit();
        $('.create-groupon-activity').show().click(function () {
            $('.tab-content .tab-pane').removeClass('active');
            $('.tab-content .tab-pane#add').addClass('active');
            $('.nav-tabs li').removeClass('active');
            $('.create-groupon-activity').hide();
        });
    });
</script>
@stop