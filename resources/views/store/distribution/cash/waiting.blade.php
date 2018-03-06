<!--
/**
 * Created by PhpStorm.
 * User: Creya
 * Date: 2017/8/24
 * Time: 9:41
 */
 -->
<div id="wait-toolbar">
    <form class="form-horizontal" id="wait-form" action="../ajax/shop/fenxiao/cash/list">
        <div class="form-group col-md-3">
            <div class="input-group col-md-12">
                <div class="input-group-addon">单号</div>
                <input type="text" class="form-control input" name="wait_cash_id" placeholder="" maxlength="60">
            </div>
        </div>
        <div class="form-group col-md-3">
            <div class="input-group col-md-12">
                <div class="input-group-addon">姓名</div>
                <input type="text" class="form-control input" name="wait_name" placeholder="" maxlength="60">
            </div>
        </div>
        <div class="form-group col-md-3">
            <div class="input-group col-md-12">
                <div class="input-group-addon">手机</div>
                <input type="text" class="form-control input" name="wait_mobile" placeholder="" maxlength="60">
            </div>
        </div>
        <div class="form-group col-md-3">
            <div class="input-group col-md-12">
                <div class="input-group-addon">昵称</div>
                <input type="text" class="form-control input" name="wait_nickname" placeholder="" maxlength="60">
            </div>
        </div>
        <div class="form-group col-md-4">
            <div class="input-group  col-md-12">
                {{--<div class="input-group-addon">时间范围</div>--}}
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input type="text"  class="form-control pull-right datetimepicker" name="wait_apply_time" placeholder="申请时间起始" readonly>
            </div>
        </div>
        <div class="form-group col-md-3">
            <div class="input-group  col-md-12">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input type="text" name="wait_verify_time" class="form-control pull-right datetimepicker" placeholder="申请时间结束" readonly>
            </div>
        </div>
        <div class="form-group col-md-1">
            <button type="submit" class="btn btn-primary">查询</button>
        </div>
        <div class="form-group col-md-1">
            <button type="reset" class="btn btn-primary" name="reset">重置</button>
        </div>
        <div class="form-group col-md-1 margin_left">
            <button type="button" class="btn btn-primary" id="wait-download">导出</button>
        </div>
    </form>
</div>
<div class="box-body">
    <table id="wait-table"
           data-toolbar="#wait-toolbar"
           data-pagination="true"
           data-id-field="id"
           data-page-size="10"
           data-page-list="[10, 25, 50, 100]"
           data-show-footer="false"
           data-side-pagination="server"
           data-query-params="queryParams"
           data-url="/ajax/shop/fenxiao/cash/list?status=1"
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

<script type="text/template" id="wait_tpl">
    <div class="wait_top_style">
        <div class="wait_per_info">个人信息</div>
        <div class="wait_div_spacing">头像:
            <img src="" class="wait_per_img"></div>
        <div class="wait_div_spacing">
            <div class="wait_div_width">昵称:
                <div class="wait_div_text wait_nickname"></div>
            </div>
            <div class="wait_div_width">姓名:
                <div class="wait_div_text wait_username"></div>
            </div>
            <div class="wait_div_width">id:
                <div class="wait_div_text wait_user_id"></div>
            </div>
        </div>
        <div class="wait_div_spacing">
            <div class="wait_div_width">手机号:
                <div class="wait_div_text wait_phone"></div>
            </div>
            <div class="wait_div_width">微信:
                <div class="wait_div_text wait_wechat"></div>
            </div>
            <div class="wait_div_width">支付宝:
                <div class="wait_div_text wait_alipay"></div>
            </div>
        </div>
        <div class="wait_div_spacing">
            <div class="wait_div_text wait_div_left">下级:
                <div class="wait_div_text wait_total_per">总共</div>
            </div>
            <div class="wait_div_text wait_div_left wait_div_left_one">一级:
                <div class="wait_div_text wait_one_per"></div>
            </div>
            <div class="wait_div_text wait_div_left wait_div_left_two">二级:
                <div class="wait_div_text wait_two_per"></div>
            </div>
            <div class="wait_div_text wait_div_left wait_div_left_thr">三级:
                <div class="wait_div_text wait_thr_per"></div>
            </div>
        </div>
        <div class="wait_div_spacing">
            <div class="wait_div_text wait_div_left">比例: </div>
            <div class="wait_div_text wait_div_left">一级佣金比例:
                <div class="wait_div_text wait_one_com"></div>
            </div>
            <div class="wait_div_text wait_div_left">二级佣金比例:
                <div class="wait_div_text wait_two_com"></div>
            </div>
            <div class="wait_div_text wait_div_left">三级佣金比例:
                <div class="wait_div_text wait_thr_com"></div>
            </div>
        </div>
        <div class="wait_div_spacing">
            <span class="wait_info_status">状态:</span>
        </div>
    </div>
    <hr>
    <div class="wait_detail_info">提现详情
        <div class="wait_post_money" >打款</div>
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
                    <span style="padding:0 0 0 20px;">打款方式</span>
                </span>
            </li>
        </ul>
        <ul>
            <li>
                <span>
                    <span style="width:75px;text-align: center;" id="wait_pay_id"></span>
                    <span style="width:135px;text-align: center;" id="wait_time_start"></span>
                    <span style="width:60px;text-align: center;" id="wait_amount_apply"></span>
                    <span style="width:50px;text-align: center;" id="wait_tran"></span>
                    <span style="width:50px;text-align: center;" id="wait_wait"></span>
                    <span style="width:130px;text-align: center;" id="wait_pay_time"> - </span>
                    <span style="width:70px;text-align: center;" id="wait_pay_status"></span>
                    <span style="width:70px;text-align: center;" id="wait_pay_type"> - </span>
                </span>
                <ul style="border-radius:5px;" class="wait_list_rows"></ul>
            </li>
        </ul>

    </div>
    <div class="btn bootbox-close-button wait_btn_close" style="">确定</div>
    <style>
        .wait_pay_id {
            width:75px;
            text-align: center;
        }
        .wait_time_start {
            width:135px;
            text-align: center;
        }
        .wait_amount_apply {
            width:70px;
            text-align: center;
        }
        .wait_tran {
            width:50px;
            text-align: center;
        }
        .wait_wait {
            width:50px;
            text-align: center;
        }
        .wait_pay_time {
            width:140px;
            text-align: center;
        }
        .wait_pay_status {
            width:65px;text-align: center;
        }
        .wait_pay_type {
            width:80px;text-align: center;
        }
        .modal-content {
            padding-bottom: 50px;;
        }
        .wait_btn_close {
            float: right;
            margin: 10px 20px 20px 0;
            border: 1px solid rgba(0, 0, 0, 0.3);
            border-radius: 5px;
        }
        .wait_btn_close:hover {
            background-color: #dddddd;
        }
        .wait_detail_info {
            padding-top: 20px;
            padding-left: 20px;
            padding-bottom: 20px;
            background-color: #eee;
            border-radius: 5px;color:#979797;
        }
        .wait_top_style {
            border:1px solid #eeeeee;
            color:#979797;
        }
        .modal-dialog {
            width: 960px;
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
        .wait_div_spacing {
            color:#000000;
            padding-left: 20px;
            margin-top: 15px;
            margin-bottom: 10px;
        }
        .wait_per_img {
            width: 40px;
            height: 40px;
            border-radius: 100px;
            margin-left: 30px;
        }
        .wait_per_info {
            padding-bottom: 20px;
            padding-left: 20px;
            padding-top: 20px;
            background-color: #eeeeee;
        }
        .wait_div_width {
            display: inline-block;
            width: 200px;
        }
        .wait_div_text {
            text-align: center;
            display: inline-block;
        }
        .wait_div_left {
            margin-right: 27px;
        }
        .wait_post_money {
            float: right;
            margin-right: 30px;
            width: 80px;
            border-radius: 10px;
            background-color: #1597CF;
            color: white;
            text-align: center;
        }
        .wait_post_money_false {
            float: right;
            margin-right: 30px;
            width: 80px;
            border-radius: 10px;
            background-color: #d3d3d3;
            color: white;
            text-align: center;
        }
        .wait_post_money:hover {
            background-color: #1d7fa9;
            cursor: pointer;
        }
        .wait_pay_true:hover {
            background-color:#23BEF8;
        }
        .wait_pay_false:hover {
            background-color:#23BEF8;
        }
    </style>
    <script>
        $(function() {
            $('.wait_post_money').click(function() {
                var wait_fans_id = $(".wait_user_id").text();
                var wait_pay_cash_id = $("#wait_pay_id").text();
                var productList = $("#wait_pay_tpl").text();
                bootbox.alert({
                    title: '<span class="text-success">打款进度</span>',
                    message: productList
                });
                $("#wait_pay_fans_id").append(wait_fans_id);
                $("#wait_pay_cash_id").append(wait_pay_cash_id);
                var wait_pay_cash_id = $("#wait_pay_cash_id").text();
                var wait_pay_fans_id = $("#wait_pay_fans_id").text();
                /*申请提现金额 等待打款金额*/
                var wait_amount_apply = $("#wait_amount_apply").text();
                var wait_wait = $("#wait_wait").text();
                $('.wait_amount_extract').append(wait_amount_apply);
                $('.wait_amount_wait').append(wait_wait);
            });
        });
        $(".modal-footer").remove();
</script>
</script>

<script type="text/template" id="wait_pay_tpl">
    <div>打款进度:</div>
    <div id="wait_pay_cash_id" hidden></div>
    <div id="wait_pay_fans_id" hidden></div>
    <div class="wait_pay_info">
        <div>提现金额</div>
        <div>已打款</div>
        <div>待打款</div>
        <div class="wait_amount_extract"></div>
        <div class="wait_amount_push">0.00</div>
        <div class="wait_amount_wait"></div>
    </div>
    <div style="width:900px;margin-top:150px;">支付方式:</div>
    <div style="width:900px;margin-top:30px;" class="wait_pay_type"></div>

    <input type="radio" value="1" checked="checked" name="wait_pay_type" id="wait_check_one">
    <label for="wait_check_one">微信</label>
    <input type="radio" value="2" name="wait_pay_type" id="wait_check_two">
    <label for="wait_check_two">支付宝</label>

    <div class="wait_operation">
        <div class="wait_pay_false bootbox-close-button">取消</div>
        <div class="wait_pay_true">打款</div>
    </div>
    <style>
        .modal-body {
            border-top:1px white solid;
            width:800px;
            height:360px;
            margin:0 auto;
        }
        .wait_pay_info {
            margin:left;
            margin-top:50px;
        }
        .wait_pay_info div {
            width:255px;
            padding:5px 0 5px 0;
            float:left;
            border:1px solid #d3d3d3;
            text-align:center;
        }
        .wait_pay_false {
            float:left;
            margin-right:20px;
            padding:5px 10px 5px 10px;
            border:1px solid #d3d3d3;
            border-radius:5px;
            cursor:pointer;
        }
        .wait_pay_true {
            float:left;
            padding:5px 10px 5px 10px;
            border:1px solid #d3d3d3;
            border-radius:5px;
            cursor:pointer;
        }
        .wait_operation {
            float:right;
            width:150px;
            padding-top:90px;
        }
        input[type=radio] {
            margin-left:150px;
        }
        .modal-body {
            height:400px;
        }
    </style>
    <script>
        $(".modal-footer").remove();
        var wait_pay_timeout;
        $('.wait_pay_false').click(function() {
            if (wait_pay_timeout) {
                clearTimeout(wait_pay_timeout);
                wait_pay_timeout = null;
            }
        });
        /*提交打款申请*/
        $('.wait_pay_true').click(function() {
            var wait_pay_fans_id = $("#wait_pay_fans_id").text();
            var wait_pay_type = $('input[name=wait_pay_type]:checked').val();
            var wait_pay_cash_id = $('#wait_pay_cash_id').text();
            /*如果10秒内未响应 则返回超时*/
            wait_pay_timeout = setTimeout(function() {
                bootbox.alert({
                    title: '<span class="text-danger">打款进度</span>',
                    message: "<div style='margin: 0 auto;text-align: center;font-size: 20px;margin-top: 10%;'>超时!</div>"
                });
            }, 10000);

            $.post('/ajax/shop/fenxiao/cash/pay/member', {'cash_id': wait_pay_cash_id,'fans_id': wait_pay_fans_id,'status': wait_pay_type},function(json) {
                if (json.code == 200) {
                    if (wait_pay_timeout) {
                        clearTimeout(wait_pay_timeout);
                        wait_pay_timeout = null;
                    }
                    var tab;
                    tab = "<div style='margin: 0 auto;text-align: center;font-size: 20px;margin-top: 10%;'>成功!</div>";
                    tab += "<div class='wait_close_btn' style='width: 60px;text-align: center;margin: 0 auto; padding:5px 5px;margin-top: 30px;border: 1px solid #d3d3d3;border-radius: 5px;'>确定</div>";
                    tab += '<style>.wait_close_btn:hover{cursor: pointer;background-color: #00a0e9}</style>';
                    tab += '<script>';
                    tab += '$(".modal-footer").remove();';
                    tab += '$(".wait_close_btn").click(function(){history.go(0)});';
                    tab += '<'+'/script>';
                    bootbox.alert({
                        title: '<span class="text-success">打款进度</span>',
                        message: tab
                    });
                }
            });
        });
    </script>
</script>

<script>
    var total_rows_wait = 0;
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
        var $table = $('#wait-table'),
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
                            field: 'wait_cash_id',
                            title: '提现单号',
                            valign: 'middle',
                            align: 'center'
                        },{
                            field: 'wait_nickname',
                            title: '昵称',
                            valign: 'middle',
                            align: 'center'
                        },{
                            field: 'headimgurl',
                            title: '头像',
                            valign: 'middle',
                            align: 'center'
                        },{
                            field: 'wait_name',
                            title: '姓名',
                            valign: 'middle',
                            align: 'center'
                        },  {
                            field: 'wait_mobile',
                            title: '手机',
                            align: 'center'
                        }, {
                            field: 'amount',
                            title: '提现金额',
                            valign: 'middle',
                            align: 'center'
                        }, {
                            field: 'payamount',
                            title: '已打款',
                            valign: 'middle',
                            align: 'center'
                        }, {
                            field: 'waitamount',
                            title: '待打款',
                            valign: 'middle',
                            align: 'center'
                        }, {
                            field: 'wait_apply_time',
                            title: '申请时间',
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
                    total_rows_wait = res.data['total'];
                    var ree = res.data['rows'];
                    ree.forEach(function(hj) {
                        hj['wait_cash_id']=hj['id'];
                        if(hj['headimgurl'] != null || hj['headimgurl'] != "") {
                            hj['headimgurl'] = "<img src='"+hj['headimgurl']+"' style='width:30px;height: 30px;' />";
                        } else {
                            hj['headimgurl'] = "<img src='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAoAAAAFCAYAAAB8ZH1oAAAALUlEQVQImWP8DwQMRAAWCPWWYWOeO0PzMWSpGIZ5ZwoY9KA8RmJNZCJGEUkKAXh/DgMb8RMjAAAAAElFTkSuQmCC' style='width:2px;height: 2px;' />";
                        }
                        hj['wait_nickname'] = hj['nickname'];
                        hj['wait_name'] = hj['name'];
                        hj['wait_mobile'] = hj['mobile'];
                        hj['wait_apply_time'] = hj['apply_time'];
                    });
                    return res.data;
                },
                /*分页列表 查询*/
                'queryParams': function(params)
                {
                    var arr = ['wait_cash_id','wait_nickname','headimgurl','wait_name','wait_mobile','amount','payamount','waitamount','wait_apply_time'];
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
            var opa = row.f_member_id;
            var opa = row.f_member_id;
            var status = row.status;
            if (status == 3) {
                var operateDate = [
                    '<a class="detail" href="javascript:void(0)" title="详情" id="'+opa+'"> 详情 </a>  ',
                    '<a class="cash_wait" href="javascript:void(0)" title="打款中" style="margin-left: 10px;"  id="'+opa+'"> 打款中 </a>  ',
                ];
            } else {
                var operateDate = [
                    '<a class="detail" href="javascript:void(0)" title="详情" id="'+opa+'"> 详情 </a>  ',
                    '<a class="cash" href="javascript:void(0)" title="打款" style="margin-left: 10px;"  id="'+opa+'"> 打款 </a>  ',
                ];
            }
            return operateDate.join('');
        }

        window.operateEvents = {
            /*详情页 弹出框 内容*/
            'click .detail': function()
            {
                var cash_id = $(this).parent().parent().children("td").get(0).innerHTML;
                var fans = $(this).attr("id");
                $.post('/ajax/shop/fenxiao/cash/detail?status=1', {'cash_id':cash_id,'fans_id':fans}, function (json)
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
                        var wechart = user.fans;
                        var pay_time = cash.verify_time;

                        var productList = $("#wait_tpl").text();
                        bootbox.alert({
                            title: '<span class="text-success">提现详情</span>',
                            message: productList
                        });
                        /*个人基本详情*/
                        $(".wait_per_img").attr('src',wechart.headimgurl);
                        $(".wait_nickname").append(wechart.nickname);
                        $(".wait_username").append(user.full_name);
                        $(".wait_user_id").append(user.fans_id);
                        $(".wait_phone").append(user.mobile);
                        $(".wait_wechat").append(user.wechat);
                        $(".wait_alipay").append(user.mobile);
                        $(".wait_one_per").append(data.user_one+"人");
                        $(".wait_two_per").append(data.user_two+"人");
                        $(".wait_thr_per").append(data.user_thr+"人");
                        //  根据分销层级 对应展示相关数据
                        if (data.level == 2) {
                            $(".wait_div_left_thr").empty();
                            data.user_thr = 0;
                        } else if (data.level == 1) {
                            $(".wait_div_left_two").empty();
                            $(".wait_div_left_thr").empty();
                            data.user_two = 0;
                            data.user_thr = 0;
                        } else if (data.level == 0) {
                            $(".wait_div_left_one").empty();
                            $(".wait_div_left_two").empty();
                            $(".wait_div_left_thr").empty();
                            data.user_one = 0;
                            data.user_two = 0;
                            data.user_thr = 0;
                        }
                        var wait_total_per = parseInt(data.user_one) +parseInt(data.user_two) +parseInt(data.user_thr);
                        $(".wait_total_per").append(wait_total_per+"人");
                        $(".wait_one_com").append(cash.commission_settings['father_commission']+"%");
                        $(".wait_two_com").append(cash.commission_settings['grand_father_commission']+"%");
                        $(".wait_thr_com").append(cash.commission_settings['great_grand_father_commission']+"%");
                        var user_active = user.is_active;
                        user_active = user_active == 1 ? "开启" : "关闭";
                        $(".wait_info_status").append(user_active);
                        $("#wait_pay_id").append(cash.id);
                        var wait_pay_id = $("#wait_pay_id").text();
                        $("#wait_time_start").append(cash.apply_time);
                        $("#wait_amount_apply").append(cash.amount);
                        $("#wait_wait").append(cash.waitamount);
                        $("#wait_tran").append(cash.payamount);
                        if (cash.status == 3) {
                            $(".wait_post_money").remove();
                            $(".wait_detail_info").append('<div class="wait_post_money_false">打款中</div>');
                        }
                        switch (cash.status) {
                            case 0: cash.status = "待审核";break;
                            case 1: cash.status = "待打款";break;
                            case 2: cash.status = "已打款";break;
                            case 3: cash.status = "打款中";break;
                        }
                        $("#wait_pay_status").append(cash.status);

                        if (cash_list.length > 0) {
                            /*打款详情列表*/
                            cash_list.forEach(function(item) {
                                item.cash_time = item.cash_time == null ? " - " : item.cash_time;
                                item.cash_type = item.cash_type == 2 ? "微信" : "支付宝";
                                if (item.status != 2 || item.waitamount != "0.00") {
                                    item.cash_type = "-";
                                }
                                switch (item.status) {
                                    case 0:item.status = "待打款";break;
                                    case 1:item.status = "已打款";break;
                                    case 2:item.status = "打款中";break;
                                }
                                if (item.waitamount == "0.00") {
                                    item.status = "已打款";
                                }
                                $(".wait_list_rows").append(
                                    '<li>'+
                                    '<span>'+
                                    '<span class="wait_pay_id">'+item.cash_id+'</span>'+
                                    '<span class="wait_time_start">'+item.apply_time+'</span>'+
                                    '<span class="wait_amount_apply">'+item.amount+'</span>'+
                                    '<span class="wait_tran">'+item.payamount+'</span>'+
                                    '<span class="wait_wait">'+item.waitamount+'</span>'+
                                    '<span class="wait_pay_time">'+item.cash_time+'</span>'+
                                    '<span class="wait_pay_status">'+item.status+'</span>'+
                                    '<span class="wait_pay_type">'+item.cash_type+'</span>'+
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
            },
            'click .cash': function()
            {
                var cash_id = $(this).parent().parent().children("td").get(0).innerHTML;
                var cash_amount = $(this).parent().parent().children("td").get(5).innerText;9
                var wait_amount = $(this).parent().parent().children("td").get(6).innerText;
                var tran_amount = $(this).parent().parent().children("td").get(7).innerText;
                var fans = $(this).attr("id");
                var productList = $("#wait_pay_tpl").text();
                bootbox.alert({
                    title: '<span class="text-success">打款进度</span>',
                    message: productList
                });
                $('#wait_pay_cash_id').append(cash_id);
                $('#wait_pay_fans_id').append(fans);
                $('.wait_amount_extract').append(cash_amount);
                $('.wait_amount_wait').append(cash_amount);
                $('.wait_tran_amount').append(tran_amount);
            },
            'click .cash_wait': function()
            {
                var tab='系统自动打款中,请耐心等待.';
                tab += '<script>$(".modal-content").css("width","600px");$(".modal-content").css("margin","0 auto");<'+'/script>';
                bootbox.alert({
                    title: '<span class="text-success"></span>',
                    message:tab
                });
            }
        };

        function getHeight() {
            return $(window).height() - $('.box-body').offset().top - 32;
        }

        initTable();

        $('#wait-form').validator().on('submit', function (e) {
            if(!e.isDefaultPrevented()){
                e.preventDefault();
            }
            $table.bootstrapTable('selectPage', 1);
        });
        $('#wait-download').click(function(){
            if (total_rows_wait > 0) {
                var wait_cash_id = $("input[name='wait_cash_id']").val();
                var wait_nickname = $("input[name='wait_nickname']").val();
                var wait_name = $("input[name='wait_name']").val();
                var wait_mobile = $("input[name='wait_mobile']").val();
                var wait_apply_time = $("input[name='wait_apply_time']").val();
                var url = "http://"+window.location.host+"/ajax/shop/fenxiao/cash/list?order=asc&load=1&status=0&wait_cash_id="+wait_cash_id+"&wait_nickname="+wait_nickname+"&wait_name="+wait_name+"&wait_mobile="+wait_mobile+"&wait_apply_time="+wait_apply_time;
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