<!--
/**
 * Created by PhpStorm.
 * User: Creya
 * Date: 2017/8/24
 * Time: 9:41
 */
 -->
<div id="tran-toolbar">
    <form class="form-horizontal" id="tran-form" action="../ajax/shop/fenxiao/cash/list">
        <div class="form-group col-md-3">
            <div class="input-group col-md-12">
                <div class="input-group-addon">单号</div>
                <input type="text" class="form-control input" name="tran_cash_id" placeholder="" maxlength="60">
            </div>
        </div>
        <div class="form-group col-md-3">
            <div class="input-group col-md-12">
                <div class="input-group-addon">姓名</div>
                <input type="text" class="form-control input" name="tran_name" placeholder="" maxlength="60">
            </div>
        </div>
        <div class="form-group col-md-3">
            <div class="input-group col-md-12">
                <div class="input-group-addon">手机</div>
                <input type="text" class="form-control input" name="tran_mobile" placeholder="" maxlength="60">
            </div>
        </div>
        <div class="form-group col-md-3">
            <div class="input-group col-md-12">
                <div class="input-group-addon">昵称</div>
                <input type="text" class="form-control input" name="tran_nickname" placeholder="" maxlength="60">
            </div>
        </div>
        <div class="form-group col-md-4">
            <div class="input-group  col-md-12">
                {{--<div class="input-group-addon">时间范围</div>--}}
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input type="text"  class="form-control pull-right datetimepicker" name="tran_apply_time" placeholder="申请时间起始" readonly>
            </div>
        </div>
        <div class="form-group col-md-3">
            <div class="input-group  col-md-12">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input type="text" name="tran_verify_time" class="form-control pull-right datetimepicker" placeholder="申请时间结束" readonly>
            </div>
        </div>
        <div class="form-group col-md-1">
            <button type="submit" class="btn btn-primary">查询</button>
        </div>
        <div class="form-group col-md-1">
            <button type="reset" class="btn btn-primary" name="reset">重置</button>
        </div>
        <div class="form-group col-md-1 margin_left">
            <button type="button" class="btn btn-primary" id="tran-download">导出</button>
        </div>
    </form>
</div>
<div class="box-body">
    <table id="tran-table"
           data-toolbar="#tran-toolbar"
           data-pagination="true"
           data-id-field="id"
           data-page-size="10"
           data-page-list="[10, 25, 50, 100]"
           data-show-footer="false"
           data-side-pagination="server"
           data-query-params="queryParams"
           data-url="/ajax/shop/fenxiao/cash/list?status=2"
           data-response-handler="responseHandler">
    </table>
</div>
<!-- /.box-body -->
<style>
    @media screen and (min-width:190px ) {
        .margin_left{
            margin-left: 15px;;
        }
    }
    /*弹出框 详情 宽度*/
    .modal-dialog {
        width:960px;
    }
</style>
@push('js')

<link href="http://vip.fenxiao.zuizan100.com.cn/statics/css/dialog.css" rel="stylesheet" type="text/css">
<script type="text/template" id="tran_tpl">
    <div class="tran_top_style">
        <div class="tran_per_info">个人信息</div>
        <div class="tran_div_spacing">头像:
            <img src="" class="tran_per_img"></div>
        <div class="tran_div_spacing">
            <div class="tran_div_width">昵称:
                <div class="tran_div_text tran_nickname"></div>
            </div>
            <div class="tran_div_width">姓名:
                <div class="tran_div_text tran_username"></div>
            </div>
            <div class="tran_div_width">id:
                <div class="tran_div_text tran_user_id"></div>
            </div>
        </div>
        <div class="tran_div_spacing">
            <div class="tran_div_width">手机号:
                <div class="tran_div_text tran_phone"></div>
            </div>
            <div class="tran_div_width">微信:
                <div class="tran_div_text tran_wechat"></div>
            </div>
        </div>
        <div class="tran_div_spacing">
            <div class="tran_div_text tran_div_left">下级:
                <div class="tran_div_text tran_total_per">总共</div>
            </div>
            <div class="tran_div_text tran_div_left tran_div_left_one">一级:
                <div class="tran_div_text tran_one_per"></div>
            </div>
            <div class="tran_div_text tran_div_left tran_div_left_two">二级:
                <div class="tran_div_text tran_two_per"></div>
            </div>
            <div class="tran_div_text tran_div_left tran_div_left_thr">三级:
                <div class="tran_div_text tran_thr_per"></div>
            </div>
        </div>
        <div class="tran_div_spacing">
            <div class="tran_div_text tran_div_left">比例: </div>
            <div class="tran_div_text tran_div_left">一级佣金比例:
                <div class="tran_div_text tran_one_com"></div>
            </div>
            <div class="tran_div_text tran_div_left">二级佣金比例:
                <div class="tran_div_text tran_two_com"></div>
            </div>
            <div class="tran_div_text tran_div_left">三级佣金比例:
                <div class="tran_div_text tran_thr_com"></div>
            </div>
        </div>
        <div class="tran_div_spacing">
            <span class="tran_info_status">状态:</span>
        </div>
    </div>
    <hr>
    <div class="tran_detail_info"><span style="float:left;">提现详情</span>
        <div class="tran_alipay_account"></div>
    </div>
    <div class="tree well">
        <div style="margin: 0 0 15px 0;"></div>
        <ul id="top">
            <li>
                <span>
                    <i class="icon-folder"></i>
                    <span style="padding:0 0 0 25px;">订单号</span>
                    <span style="padding:0 0 0 45px;">申请时间</span>
                    <span style="padding:0 0 0 30px;">申请金额</span>
                    <span style="margin:0 0 0 10px;">已打款</span>
                    <span style="margin:0 0 0 20px;">待打款</span>
                    <span style="margin:0 0 0 40px;">打款完成时间</span>
                    <span style="padding:0 0 0 50px;">状态</span>
                </span>
            </li>
        </ul>
        <ul>
            <li>
                <span>
                    <span style="width:75px;text-align: center;" id="tran_pay_id"></span>
                    <span style="width:135px;text-align: center;" id="tran_time_start"></span>
                    <span style="width:60px;text-align: center;" id="tran_amount_apply"></span>
                    <span style="width:50px;text-align: center;" id="tran_tran"></span>
                    <span style="width:50px;text-align: center;" id="tran_wait"></span>
                    <span style="width:130px;text-align: center;" id="tran_pay_time"></span>
                    <span style="width:70px;text-align: center;" id="tran_pay_status"></span>
                </span>
                <ul style="border-radius:5px;" class="tran_list_rows"></ul>
            </li>
        </ul>

    </div>
    <div class="btn bootbox-close-button tran_btn_close" style="">确定</div>
    <style>
        .tran_alipay_mobile {
            float:left;
            margin-left:20px;
        }
        .tran_pay_id {
            width:75px;
            text-align: center;
        }
        .tran_time_start {
            width:135px;
            text-align: center;
        }
        .tran_amount_apply {
            width:70px;
            text-align: center;
        }
        .tran_tran {
            width:50px;
            text-align: center;
        }
        .tran_wait {
            width:50px;
            text-align: center;
        }
        .tran_pay_time {
            width:140px;
            text-align: center;
        }
        .tran_pay_status {
            width:65px;text-align: center;
        }
        .tran_pay_type {
            width:80px;text-align: center;
        }
        .modal-content {
            padding-bottom: 50px;;
        }
        .tran_btn_close {
            float: right;
            margin: 10px 20px 20px 0;
            border: 1px solid rgba(0, 0, 0, 0.3);
            border-radius: 5px;
        }
        .tran_btn_close:hover {
            background-color: #dddddd;
        }
        .tran_detail_info {
            padding-top: 20px;
            padding-left: 20px;
            padding-bottom: 30px;
            background-color: #eee;
            border-radius: 5px;color:#979797;
        }
        .tran_top_style {
            border:1px solid #eeeeee;
            color:#979797;
        }
        .modal-dialog {
            width: 860px;
        }
        .tree {
            min-height: 20px;
            padding: 19px;
            margin-bottom: 20px;
            background-color: #fbfbfb;
            -webkit-border-radius: 4px;
            -moz-border-radius: 4px;
            border-radius: 4px;
            -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);
            -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05)
        }
        .tree li {
            list-style-type: none;
            margin: 0 0 0 -40px;
            position: relative
        }
        .tree li::before, .tree li::after {
            left: -20px;
            position: absolute;
            right: auto
        }
        .tree li::before {
            bottom: 50px;
            height: 100%;
            top: 0;
        }
        .tree li::after {
            height: 20px;
            top: 25px;
        }
        .tree li span {
            border-radius: 5px;
            display: inline-block;
            padding: 2px 2px;
            text-decoration: none
        }
        .tree li.parent_li>span {
            cursor: pointer;
        }
        .tree>ul>li::before, .tree>ul>li::after {
            border: 0
        }
        .tree li:last-child::before {
            height: 30px
        }
        .tree li.parent_li>span:hover, .tree li.parent_li>span:hover+ul li span {
            background: #eee;
        }
        .parent_li span {
            margin: 2px 10px 2px 10px;
        }
        .parent_li ul {
            background: #eee;
        }
        #top li span span {
            margin: 0 15px 0 15px;
        }
        .tran_div_spacing {
            color:#000000;
            padding-left: 20px;
            margin-top: 15px;
            margin-bottom: 10px;
        }
        .tran_per_img {
            width: 40px;
            height: 40px;
            border-radius: 100px;
            margin-left: 30px;
        }
        .tran_per_info {
            padding-bottom: 20px;
            padding-left: 20px;
            padding-top: 20px;
            background-color: #eeeeee;
        }
        .tran_div_width {
            display: inline-block;
            width: 200px;
        }
        .tran_div_text {
            text-align: center;
            display: inline-block;
        }
        .tran_div_left {
            margin-right: 27px;
        }
        .tran_pay_true:hover {
            background-color:#23BEF8;
        }
        .tran_pay_false:hover {
            background-color:#23BEF8;
        }
    </style>
    <script>
        $(function() {
            $('.tran_post_money').click(function() {
                var tran_fans_id = $(".tran_user_id").text();
                var tran_pay_cash_id = $("#tran_pay_id").text();
                var tran_pay_mobile = $('#tran_pay_tel').text();
                var productList = $("#tran_pay_tpl").text();
                bootbox.alert({
                    title: '<span class="text-success">打款进度</span>',
                    message: productList
                });
                $("#tran_pay_fans_id").append(tran_fans_id);
                $("#tran_pay_cash_id").append(tran_pay_cash_id);
                var tran_pay_cash_id = $("#tran_pay_cash_id").text();
                var tran_pay_fans_id = $("#tran_pay_fans_id").text();
                /*申请提现金额 等待打款金额*/
                var tran_amount_apply = $("#tran_amount_apply").text();
                var tran_wait = $("#tran_wait").text();
                $('.tran_amount_extract').append(tran_amount_apply);
                $('.tran_amount_wait').append(tran_wait);
                $('#tran_alipay_mobile').val(tran_pay_mobile);
            });
        });
        $(".modal-footer").remove();

</script>
</script>

<script>
    var total_rows_tran = 0;
    function closeWindows()
    {
        if (navigator.userAgent.indexOf("Firefox") != -1 || navigator.userAgent.indexOf("Chrome") !=-1)
        {
            window.location.href="about:blank";
            open(location, '_self').close();
        }
        else
        {
            window.opener = null;
            window.open("", "_self");
            window.close();
        }
    }

    function submitForm(iframeWin, topWin)
    {
        closeWindows();
        return false;
    }

    function getToTime(day)
    {
        return new Date(parseInt(day) * 1000).toLocaleString().replace(/:\d{1,2}$/,' ');
    }

    $(document).ready(function () {
        var tran_alipay_account = new Array();
        var $table = $('#tran-table'),
                selections = [];

        function initTable()
        {
            /*表格 字段声明*/
            $table.bootstrapTable({
                pagination: true,/*是否分页显示*/
                sidePagination: "server", /*分页方式：client客户端分页，server服务端分页*/
                smartDisplay: false,/*隐藏分页*/
                paginationPreText: "上一页",
                paginationNextText: "下一页",
                pageNumber: 1,
                pageSize: 10,
                height: getHeight(),
                columns: [
                    [
                        {
                            field: 'tran_cash_id',
                            title: '提现单号',
                            valign: 'middle',
                            align: 'center'
                        },{
                            field: 'tran_nickname',
                            title: '昵称',
                            valign: 'middle',
                            align: 'center'
                        },{
                            field: 'headimgurl',
                            title: '头像',
                            valign: 'middle',
                            align: 'center'
                        },{
                            field: 'tran_name',
                            title: '姓名',
                            valign: 'middle',
                            align: 'center'
                        },  {
                            field: 'tran_mobile',
                            title: '手机',
                            align: 'center'
                        }, {
                            field: 'amount',
                            title: '提现金额',
                            valign: 'middle',
                            align: 'center'
                        }, {
                            field: 'payamount',
                            title: '打款金额',
                            align: 'center',
                            valign: 'middle'
                        }, {
                            field: 'apply_time',
                            title: '申请时间',
                            align: 'center',
                            valign: 'middle'
                        }, {
                            field: 'verify_time',
                            title: '打款时间',
                            align: 'center',
                            valign: 'middle'
                        }, {
                            field: 'operate',
                            title: '操作',
                            align: 'center',
                            valign: 'middle',
                            events: operateEvents,
                            formatter: operateFormatter
                        }
                    ]
                ],
                /*获取数据*/
                responseHandler: function (res)
                {
                    /*第一次进入页面时,保存总记录数,进行其他条件筛选时*/
                    total_rows_tran = res.data['total'];
                    var ree = res.data['rows'];
                    ree.forEach(function(hj) {
                        tran_alipay_account[parseInt(hj['id'])] = hj['alipay_account'];
                        hj['tran_cash_id']=hj['id'];
                        if(hj['headimgurl'] != null) {
                            hj['headimgurl'] = "<img src='"+hj['headimgurl']+"' style='width:30px;height: 30px;' />";
                        } else {
                            hj['headimgurl'] = "<img src='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAoAAAAFCAYAAAB8ZH1oAAAALUlEQVQImWP8DwQMRAAWCPWWYWOeO0PzMWSpGIZ5ZwoY9KA8RmJNZCJGEUkKAXh/DgMb8RMjAAAAAElFTkSuQmCC' style='width:2px;height: 2px;' />";
                        }
                        hj['tran_nickname'] = hj['nickname'];
                        hj['tran_name'] = hj['name'];
                        hj['tran_mobile'] = hj['mobile'];
                        hj['tran_alipay_account'] = hj['alipay_account'];
                        hj['tran_apply_time'] = hj['apply_time'];
                    });
                    return res.data;
                },
                /*分页列表 查询*/
                'queryParams': function(params)
                {
                    var arr = ['tran_cash_id','tran_nickname','headimgurl','tran_name','tran_mobile','amount','audit_apply_time','verify_time'];
                    arr.forEach(function(item)
                    {
                        params[item] = $('[name='+item+']').val()
                    });
                    return params;
                }
            });

            setTimeout(function () {
                $table.bootstrapTable('resetView');
            }, 200);

            $(window).resize(function () {
                $table.bootstrapTable('resetView', {
                    height: getHeight()
                });
            });
        }

        /*分销 订单列表 状态*/
        function statusType(value, row, index)
        {
            var type=row.status;
            switch(type)
            {
                case 0:
                    return "未完成";
                    break;
                case 1:
                    return "已完成";
                    break;
                case 2:
                    return "已过期";
                    break;
                case 3:
                    return "退款作废";
                    break;
                case 4:
                    return "已取消";
                    break;
                    defaule:
                            return "";
                    break;
            }
        }
        /*详情页 弹出框按钮*/
        function operateFormatter(value, row, index)
        {
            var opa = row.weapp_user_id;
            var operateDate = [
                '<a class="detail" href="javascript:void(0)" title="详情" id="'+opa+'"> 详情 </a>  '
            ];
            return operateDate.join('');
        }

        window.operateEvents = {
            /*详情页 弹出框 内容*/
            'click .detail': function()
            {
                var cash_id = $(this).parent().parent().children("td").get(0).innerHTML;
                var fans = $(this).attr("id");
                $.post('/ajax/shop/fenxiao/cash/detail?status=2', {'cash_id':cash_id,'fans_id':fans}, function (json)
                {
                    var tab;
                    if(json.code=200)
                    {
                        var data=json.data;
                        var cash = data.cash;
                        if (cash == null) {
                            return false;
                        }
                        if(cash.commission_settings == null) {
                            cash.commission_settings['father_commission'] = 0;
                            cash.commission_settings['grand_father_commission'] = 0;
                            cash.commission_settings['great_grand_father_commission'] = 0;
                        }
                        var user = data.user;
                        var cash_list = cash.cash_details;
                        var wechart = user.weapp_user;
                        var pay_time = cash.verify_time;
                        var productList = $("#tran_tpl").text();
                        bootbox.alert({
                            title: '<span class="text-success">提现详情</span>',
                            message: productList
                        });
                        /*个人基本详情*/
                        $(".tran_per_img").attr('src',wechart.headimgurl);
                        $(".tran_nickname").append(wechart.nickname);
                        $(".tran_username").append(user.full_name);
                        $(".tran_user_id").append(user.weapp_user_id);
                        $(".tran_phone").append(user.mobile);
                        $(".tran_wechat").append(user.wechat);
                        if (cash.type == 1) {//  支付宝打款
                            $(".tran_alipay_account").append("提现账号: 支付宝 <span id='tran_pay_tel'>"+cash.alipay_account+"<"+"/span>");
                        }
                        $(".tran_one_per").append(data.user_one+"人");
                        $(".tran_two_per").append(data.user_two+"人");
                        $(".tran_thr_per").append(data.user_thr+"人");
                        //  根据分销层级 对应展示相关数据
                        if (data.level == 2) {
                            $(".tran_div_left_thr").empty();
                            $('.tran_thr_com').parent().remove();
                            data.user_thr = 0;
                        } else if (data.level == 1) {
                            $(".tran_div_left_two").empty();
                            $(".tran_div_left_thr").empty();
                            $('.tran_thr_com').parent().remove();
                            $('.tran_two_com').parent().remove();
                            data.user_two = 0;
                            data.user_thr = 0;
                        } else if (data.level == 0) {
                            $(".tran_div_left_one").empty();
                            $(".tran_div_left_two").empty();
                            $(".tran_div_left_thr").empty();
                            $('.tran_thr_com').parent().remove();
                            $('.tran_two_com').parent().remove();
                            $('.tran_one_com').parent().remove();
                            data.user_one = 0;
                            data.user_two = 0;
                            data.user_thr = 0;
                        }
                        var tran_total_per = parseInt(data.user_one) +parseInt(data.user_two) +parseInt(data.user_thr);
                        $(".tran_total_per").append(tran_total_per+"人");
                        $(".tran_one_com").append(cash.commission_settings['father_commission']+"%");
                        $(".tran_two_com").append(cash.commission_settings['grand_father_commission']+"%");
                        $(".tran_thr_com").append(cash.commission_settings['great_grand_father_commission']+"%");
                        var user_active = user.is_active;
                        user_active = user_active == 1 ? "开启" : "关闭";
                        $(".tran_info_status").append(user_active);
                        $("#tran_pay_id").append(cash.id);
                        var tran_pay_id = $("#tran_pay_id").text();
                        $("#tran_time_start").append(cash.apply_time);
                        $("#tran_amount_apply").append(cash.amount);
                        $("#tran_pay_time").append(cash.verify_time);
                        $("#tran_wait").append(cash.waitamount);
                        $("#tran_tran").append(cash.payamount);
                        if (cash.status == 3) {
                            $(".tran_post_money").remove();
                            $(".tran_detail_info").append('<div class="tran_post_money_false">打款中</div>');
                        }
                        switch (cash.status) {
                            case 0: cash.status = "待审核";break;
                            case 1: cash.status = "待打款";break;
                            case 2: cash.status = "已打款";break;
                            case 3: cash.status = "打款中";break;
                        }
                        $("#tran_pay_status").append(cash.status);

                        if (cash_list.length > 0) {
                            /*打款详情列表*/
                            cash_list.forEach(function(item) {
                                item.cash_time = item.cash_time == null ? " - " : item.cash_time;
                                switch (item.status) {
                                    case 0:item.status = "待打款";break;
                                    case 1:item.status = "已打款";break;
                                    case 2:item.status = "打款中";break;
                                }
                                if (item.waitamount == "0.00") {
                                    item.status = "已打款";
                                }
                                $(".tran_list_rows").append(
                                        '<li>'+
                                        '<span>'+
                                        '<span class="tran_pay_id">'+item.cash_id+'</span>'+
                                        '<span class="tran_time_start">'+item.apply_time+'</span>'+
                                        '<span class="tran_amount_apply">'+item.amount+'</span>'+
                                        '<span class="tran_tran">'+item.payamount+'</span>'+
                                        '<span class="tran_wait">'+item.waitamount+'</span>'+
                                        '<span class="tran_pay_time">'+item.cash_time+'</span>'+
                                        '<span class="tran_pay_status">'+item.status+'</span>'+
                                        '</span>'+
                                        '</li> '
                                );
                            });
                        }
                        $('.tree li:has(ul)').addClass('parent_li').find(' > span').attr('title', '隐藏详情');
                        $('.tree li.parent_li > span').on('click',function(e) {
                            var children = $(this).parent('li.parent_li').find(' > ul > li');
                            if (children.is(':visible')) {
                                children.hide('fast');
                                $(this).attr('title', '查看详情').find(' > i').addClass('icon-plus-sign').removeClass('icon-minus-sign');
                            } else {
                                children.show('fast');
                                $(this).attr('title', '隐藏详情').find(' > i').addClass('icon-minus-sign').removeClass('icon-plus-sign');
                            }
                            e.stopPropagation();
                        });
                        function hidden_ul() {
                            var childrens = $('.tree li.parent_li > span').parent('li.parent_li').find(' > ul > li');
                            childrens.hide('fast');
                            $('.tree li.parent_li > span').attr('title', '查看详情').find(' > i').addClass('icon-plus-sign').removeClass('icon-minus-sign');
                        }
                        hidden_ul();
                    }
                }, 'json');
            }
        };

        function getHeight() {
            return $(window).height() - $('.box-body').offset().top - 32;
        }

        initTable();

        $('#tran-form').validator().on('submit', function (e) {
            if(!e.isDefaultPrevented()){
                e.preventDefault();
            }
            $table.bootstrapTable('selectPage', 1);
        });
        $('#tran-download').click(function(){
            if (total_rows_tran > 0) {
                var tran_cash_id = $("input[name='tran_cash_id']").val();
                var tran_nickname = $("input[name='tran_nickname']").val();
                var tran_name = $("input[name='tran_name']").val();
                var tran_mobile = $("input[name='tran_mobile']").val();
                var tran_apply_time = $("input[name='tran_apply_time']").val();
                var url = "http://"+window.location.host+"/ajax/shop/fenxiao/cash/list?order=asc&load=1&status=2&tran_cash_id="+tran_cash_id+"&tran_nickname="+tran_nickname+"&tran_name="+tran_name+"&tran_mobile="+tran_mobile+"&tran_apply_time="+tran_apply_time;
                window.open(url);
            } else {
                bootbox.alert({
                    title: '<span class="text-danger">详情</span>',
                    message: '没有记录,导出EXCEL失败!'
                });
            }
        });
        // 日期控件
        $('.datetimepicker').datetimepicker({
            autoclose: true,
            language: 'zh-CN',
            format: 'yyyy-mm-dd'
        });
    });
</script>
@endpush