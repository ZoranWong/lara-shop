<!--
/**
 * Created by PhpStorm.
 * User: Creya
 * Date: 2017/8/24
 * Time: 9:41
 */
 -->
<div id="audit_toolbar">
    <form class="form-horizontal" id="audit_form" action="../ajax/shop/fenxiao/cash/list">
        <div class="form-group col-md-3">
            <div class="input-group col-md-12">
                <div class="input-group-addon">单号</div>
                <input type="text" class="form-control input" name="audit_cash_id" placeholder="" maxlength="60">
            </div>
        </div>
        <div class="form-group col-md-3">
            <div class="input-group col-md-12">
                <div class="input-group-addon">姓名</div>
                <input type="text" class="form-control input" name="audit_name" placeholder="" maxlength="60">
            </div>
        </div>
        <div class="form-group col-md-3">
            <div class="input-group col-md-12">
                <div class="input-group-addon">手机</div>
                <input type="text" class="form-control input" name="audit_mobile" placeholder="" maxlength="60">
            </div>
        </div>
        <div class="form-group col-md-3">
            <div class="input-group col-md-12">
                <div class="input-group-addon">昵称</div>
                <input type="text" class="form-control input" name="audit_nickname" placeholder="" maxlength="60">
            </div>
        </div>
        <div class="form-group col-md-4">
            <div class="input-group  col-md-12">
                {{--<div class="input-group-addon">时间范围</div>--}}
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input type="text"  class="form-control pull-right datetimepicker" name="audit_apply_time" placeholder="申请时间起始" readonly>
            </div>
        </div>
        <div class="form-group col-md-3">
            <div class="input-group  col-md-12">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input type="text" name="audit_verify_time" class="form-control pull-right datetimepicker" placeholder="申请时间结束" readonly>
            </div>
        </div>
        <div class="form-group col-md-1">
            <button type="submit" class="btn btn-primary">查询</button>
        </div>
        <div class="form-group col-md-1">
            <button type="reset" class="btn btn-primary" name="reset">重置</button>
        </div>
        <div class="form-group col-md-1 margin_left">
            <button type="button" class="btn btn-primary" id="audit_downloa">导出</button>
        </div>
    </form>
</div>
<div class="box-body">
    <table id="audit_table"
           data-toolbar="#audit_toolbar"
           data-pagination="true"
           data-id-field="id"
           data-page-size="10"
           data-page-list="[10, 25, 50, 100]"
           data-show-footer="false"
           data-side-pagination="server"
           data-query-params="queryParams"
           data-url="/ajax/distribution/cash/list?status=0"
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
    .fixed-table-container {
        min-height:278px;
    }
</style>

<link href="http://vip.fenxiao.zuizan100.com.cn/statics/css/dialog.css" rel="stylesheet" type="text/css">

<script type="text/template" id="audit_tpl">
    <div class="audit_top_style">
        <div class="audit_per_info">个人信息</div>
        <div class="audit_div_spacing">头像:
            <img src="" class="audit_per_img"></div>
        <div class="audit_div_spacing">
            <div class="audit_div_width">昵称:
                <div class="audit_div_text audit_nickname"></div>
            </div>
            <div class="audit_div_width">姓名:
                <div class="audit_div_text audit_username"></div>
            </div>
            <div class="audit_div_width">id:
                <div class="audit_div_text audit_user_id"></div>
            </div>
        </div>
        <div class="audit_div_spacing">
            <div class="audit_div_width">手机号:
                <div class="audit_div_text audit_phone"></div>
            </div>
            <div class="audit_div_width">微信:
                <div class="audit_div_text audit_wechat"></div>
            </div>
            {{--<div class="audit_div_width">支付宝:--}}
                {{--<div class="audit_div_text audit_alipay"></div>--}}
            {{--</div>--}}
        </div>
        <div class="audit_div_spacing">
            <div class="audit_div_text audit_div_left">下级:
                <div class="audit_div_text audit_total_per">总共</div>
            </div>
            <div class="audit_div_text audit_div_left audit_div_left_one">一级:
                <div class="audit_div_text audit_one_per"></div>
            </div>
            <div class="audit_div_text audit_div_left audit_div_left_two">二级:
                <div class="audit_div_text audit_two_per"></div>
            </div>
            <div class="audit_div_text audit_div_left audit_div_left_thr">三级:
                <div class="audit_div_text audit_thr_per"></div>
            </div>
        </div>
        <div class="audit_div_spacing">
            <div class="audit_div_text audit_div_left">比例: </div>
            <div class="audit_div_text audit_div_left">一级佣金比例:
                <div class="audit_div_text audit_one_com"></div>
            </div>
            <div class="audit_div_text audit_div_left">二级佣金比例:
                <div class="audit_div_text audit_two_com"></div>
            </div>
            <div class="audit_div_text audit_div_left">三级佣金比例:
                <div class="audit_div_text audit_thr_com"></div>
            </div>
        </div>
        <div class="audit_div_spacing">
            <span class="audit_info_status">状态:</span>
        </div>
    </div>
    <hr>
    <div class="audit_detail_info"><span style="float:left;">提现详情</span>
        <div class="audit_alipay_account"></div>
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
                    <span style="width:75px;text-align: center;" id="audit_pay_id"></span>
                    <span style="width:135px;text-align: center;" id="audit_time_start"></span>
                    <span style="width:60px;text-align: center;" id="audit_amount_apply"></span>
                    <span style="width:50px;text-align: center;" id="audit_tran">0.00</span>
                    <span style="width:50px;text-align: center;" id="audit_wait"></span>
                    <span style="width:130px;text-align: center;" id="audit_pay_time"> - </span>
                    <span style="width:70px;text-align: center;" id="audit_pay_status">待审核</span>
                </span>
                <ul style="border-radius:5px;" class="audit_list_rows"></ul>
            </li>
        </ul>

    </div>
    <div class="btn bootbox-close-button audit_btn_close" style="">确定</div>
    <style>
        .audit_alipay_mobile {
            float:left;
            margin-left:20px;
        }
        .audit_pay_id {
            width:75px;
            text-align: center;
        }
        .audit_time_start {
            width:135px;
            text-align: center;
        }
        .audit_amount_apply {
            width:70px;
            text-align: center;
        }
        .audit_tran {
            width:50px;
            text-align: center;
        }
        .audit_wait {
            width:50px;
            text-align: center;
        }
        .audit_pay_time {
            width:140px;
            text-align: center;
        }
        .audit_pay_status {
            width:65px;text-align: center;
        }
        .audit_pay_type {
            width:80px;text-align: center;
        }
        .modal-content {
            padding-bottom: 50px;;
        }
        .audit_btn_close {
            float: right;
            margin: 10px 20px 20px 0;
            border: 1px solid rgba(0, 0, 0, 0.3);
            border-radius: 5px;
        }
        .audit_btn_close:hover {
            background-color: #dddddd;
        }
        .audit_detail_info {
            padding-top: 20px;
            padding-left: 20px;
            padding-bottom: 30px;
            background-color: #eee;
            border-radius: 5px;color:#979797;
        }
        .audit_top_style {
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
        .audit_div_spacing {
            color:#000000;
            padding-left: 20px;
            margin-top: 15px;
            margin-bottom: 10px;
        }
        .audit_per_img {
            width: 40px;
            height: 40px;
            border-radius: 100px;
            margin-left: 30px;
        }
        .audit_per_info {
            padding-bottom: 20px;
            padding-left: 20px;
            padding-top: 20px;
            background-color: #eeeeee;
        }
        .audit_div_width {
            display: inline-block;
            width: 200px;
        }
        .audit_div_text {
            text-align: center;
            display: inline-block;
        }
        .audit_div_left {
            margin-right: 27px;
        }
        .audit_pay_true:hover {
            background-color:#23BEF8;
        }
        .audit_pay_false:hover {
            background-color:#23BEF8;
        }
    </style>
    <script>
        $(".modal-footer").remove();
    </script>
</script>

<script type="text/template" id="audit_pay_tpl">
    <div>打款进度:</div>
    <div id="audit_pay_cash_id" hidden></div>
    <div id="audit_pay_fans_id" hidden></div>
    <div class="audit_pay_info">
        <div>提现金额</div>
        <div>已打款</div>
        <div>待打款</div>
        <div class="audit_amount_extract"></div>
        <div class="audit_amount_push">0.00</div>
        <div class="audit_amount_wait"></div>
    </div>
    <div class="audit_pay_type_info">
        <div class="audit_extract_no">提现账号 :</div>
        <div class="audit_pay_mobile_set">
                <span>支付宝 :</span>
                <span><input type="text" name="mobile" id="autit_alipay_account"></span>
        </div>
    </div>
    <div class="audit_operation">
        <div class="audit_pay_false bootbox-close-button">取消</div>
        <div class="audit_pay_true">打款</div>
    </div>
    <style>

        .audit_pay_true:hover {
            background-color:#23BEF8;
        }
        .audit_pay_mobile_set span {
            margin-left:15px;
        }
        .audit_pay_mobile_set {
            margin-top: 25px;
            padding-left: 30px;
        }
        .audit_pay_type_info {
            margin-top:130px;
        }
        .modal-body {
            border-top:1px white solid;
            width:800px;
            height:360px;
            margin:0 auto;
        }
        .audit_pay_info {
            margin:left;
            margin-top:50px;
        }
        .audit_pay_info div {
            width:255px;
            padding:5px 0 5px 0;
            float:left;
            border:1px solid #d3d3d3;
            text-align:center;
        }
        .audit_pay_false {
            float:left;
            margin-right:20px;
            padding:5px 10px 5px 10px;
            border:1px solid #d3d3d3;
            border-radius:5px;
            cursor:pointer;
        }
        .audit_pay_true {
            float:left;
            padding:5px 10px 5px 10px;
            border:1px solid #23BEF8;
            background-color:#23BEF8;
            border-radius:5px;
            cursor:pointer;
        }
        .audit_pay_true:hover {
            background-color:white;
        }
        .audit_operation {
            float:right;
            width:150px;
            padding-top:90px;
        }
        input[type=radio] {
            margin-left:150px;
        }
        .modal-body {
            height:380px;
        }
    </style>
    <script>
        $(".modal-footer").remove();
        var audit_pay_timeout;
        $('.audit_pay_false').click(function() {
            if (audit_pay_timeout) {
                clearTimeout(audit_pay_timeout);
                audit_pay_timeout = null;
            }
        });
        /*提交打款申请*/
        $('.audit_pay_true').click(function() {
            var audit_pay_fans_id = $("#audit_pay_fans_id").text();
            //  小程序默认商家自行转账给分销商 转账成功后商家更改打款状态
//            var audit_pay_type = $('input[name=audit_pay_type]:checked').val();
            var audit_pay_cash_id = $('#audit_pay_cash_id').text();
            var audit_alipay = $('#autit_alipay_account').val();
            if(audit_alipay == ""){
                bootbox.alert({
                    title: '<span class="text-danger">打款进度</span>',
                    message: "<div style='margin: 0 auto;text-align: center;font-size: 20px;margin-top: 10%;'>提现账号不能为空!</div>"
                });
                return false;
            }
            var audit_is_account = audit_alipay.match(/[.-_|a-zA-Z0-9]{1,}/);
            var audit_is_mail = audit_alipay.match(/^([a-zA-Z0-9|_.-])+@(([a-zA-Z0-9|-])+.)+([a-zA-Z0-9]{2,4})/);
            if (audit_is_account == null && audit_is_mail == null) {
                bootbox.alert({
                    title: '<span class="text-danger">打款进度</span>',
                    message: "<div style='margin: 0 auto;text-align: center;font-size: 20px;margin-top: 10%;'>账号格式不正确!</div>"
                });
                return false;
            } else if (audit_is_account == null && audit_alipay != audit_is_mail[0]) {
                bootbox.alert({
                    title: '<span class="text-danger">打款进度</span>',
                    message: "<div style='margin: 0 auto;text-align: center;font-size: 20px;margin-top: 10%;'>账号格式不正确!</div>"
                });
                return false;
            } else if (audit_alipay != audit_is_account[0] && audit_is_mail == null) {
                bootbox.alert({
                    title: '<span class="text-danger">打款进度</span>',
                    message: "<div style='margin: 0 auto;text-align: center;font-size: 20px;margin-top: 10%;'>账号格式不正确!</div>"
                });
                return false;
            }
            /*如果10秒内未响应 则返回超时*/
            audit_pay_timeout = setTimeout(function() {
                bootbox.alert({
                    title: '<span class="text-danger">打款进度</span>',
                    message: "<div style='margin: 0 auto;text-align: center;font-size: 20px;margin-top: 10%;'>超时!</div>"
                });
            }, 10000);

            $.post('/ajax/shop/fenxiao/cash/pay/member', {'cash_id': audit_pay_cash_id,'fans_id': audit_pay_fans_id,'alipay_account':audit_alipay,'status': 2},function(json) {
                if (json.code == 200) {
                    if (audit_pay_timeout) {
                        clearTimeout(audit_pay_timeout);
                        audit_pay_timeout = null;
                    }
                    var tab;
                    tab = "<div style='margin: 0 auto;text-align: center;font-size: 20px;margin-top: 10%;'>成功!</div>";
                    tab += "<div class='audit_close_btn' style='width: 60px;text-align: center;margin: 0 auto; padding:5px 5px;margin-top: 30px;border: 1px solid #d3d3d3;border-radius: 5px;'>确定</div>";
                    tab += '<style>.audit_close_btn:hover{cursor: pointer;background-color: #00a0e9}</style>';
                    tab += '<script>';
                    tab += '$(".modal-footer").remove();';
                    tab += '$(".audit_close_btn").click(function(){history.go(0)});';
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
    var total_rows_audit = 0;
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
        var autid_alipay_account = new Array();
        var $table = $('#audit_table'),
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
                            field: 'audit_cash_id',
                            title: '提现单号',
                            valign: 'middle',
                            align: 'center'
                        },{
                            field: 'audit_nickname',
                            title: '昵称',
                            valign: 'middle',
                            align: 'center'
                        },{
                            field: 'headimgurl',
                            title: '头像',
                            valign: 'middle',
                            align: 'center'
                        },{
                            field: 'audit_name',
                            title: '姓名',
                            valign: 'middle',
                            align: 'center'
                        },  {
                            field: 'audit_mobile',
                            title: '手机',
                            align: 'center'
                        }, {
                            field: 'amount',
                            title: '提现金额',
                            valign: 'middle',
                            align: 'center'
                        }, {
                            field: 'audit_apply_time',
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
                    total_rows_audit = res.data['total'];
                    var ree = res.data['rows'];
                    ree.forEach(function(hj) {
                        autid_alipay_account[parseInt(hj['id'])] = hj['alipay_account'];
                        hj['audit_cash_id']=hj['id'];
                        if(hj['headimgurl'] != null) {
                            hj['headimgurl'] = "<img src='"+hj['headimgurl']+"' style='width:30px;height: 30px;' />";
                        } else {
                            hj['headimgurl'] = "<img src='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAoAAAAFCAYAAAB8ZH1oAAAALUlEQVQImWP8DwQMRAAWCPWWYWOeO0PzMWSpGIZ5ZwoY9KA8RmJNZCJGEUkKAXh/DgMb8RMjAAAAAElFTkSuQmCC' style='width:2px;height: 2px;' />";
                        }
                        hj['audit_nickname'] = hj['nickname'];
                        hj['audit_name'] = hj['name'];
                        hj['audit_mobile'] = hj['mobile'];
                        hj['audit_apply_time'] = hj['apply_time'];
                    });
                    return res.data;
                },
                /*分页列表 查询*/
                'queryParams': function(params)
                {
                    var arr = ['audit_cash_id','audit_nickname','headimgurl','audit_name','audit_mobile','amount','audit_apply_time'];
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
                $.post('/ajax/distribution/cash/detail?status=0', {'cash_id':cash_id,'fans_id':fans}, function (json)
                {
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

                        var productList = $("#audit_tpl").text();
                        bootbox.alert({
                            title: '<span class="text-success">提现详情</span>',
                            message: productList
                        });
                        /*个人基本详情*/
                        $(".audit_per_img").attr('src',wechart.headimgurl);
                        $(".audit_nickname").append(wechart.nickname);
                        $(".audit_username").append(user.full_name);
                        $(".audit_user_id").append(user.weapp_user_id);
                        $(".audit_phone").append(user.mobile);
                        $(".audit_wechat").append(user.wechat);
                        if (cash.type == 1) {//  支付宝打款
                            $(".audit_alipay_account").append("提现账号: 支付宝 <span id='audit_pay_tel'>"+cash.alipay_account+"<"+"/span>");
                        }
                        $(".audit_one_per").append(data.user_one+"人");
                        $(".audit_two_per").append(data.user_two+"人");
                        $(".audit_thr_per").append(data.user_thr+"人");
                        //  根据分销层级 对应展示相关数据
                        if (data.level == 2) {
                            $(".audit_div_left_thr").empty();
                            $('.audit_thr_com').parent().remove();
                            data.user_thr = 0;
                        } else if (data.level == 1) {
                            $(".audit_div_left_two").empty();
                            $(".audit_div_left_thr").empty();
                            $('.audit_thr_com').parent().remove();
                            $('.audit_two_com').parent().remove();
                            data.user_two = 0;
                            data.user_thr = 0;
                        } else if (data.level == 0) {
                            $(".audit_div_left_one").empty();
                            $(".audit_div_left_two").empty();
                            $(".audit_div_left_thr").empty();
                            $('.audit_thr_com').parent().remove();
                            $('.audit_two_com').parent().remove();
                            $('.audit_one_com').parent().remove();
                            data.user_one = 0;
                            data.user_two = 0;
                            data.user_thr = 0;
                        }
                        var audit_total_per = parseInt(data.user_one) +parseInt(data.user_two) +parseInt(data.user_thr);
                        $(".audit_total_per").append(audit_total_per+"人");
                        $(".audit_one_com").append(cash.commission_settings['father_commission']+"%");
                        $(".audit_two_com").append(cash.commission_settings['grand_father_commission']+"%");
                        $(".audit_thr_com").append(cash.commission_settings['great_grand_father_commission']+"%");
                        var user_active = user.is_active;
                        user_active = user_active == 1 ? "开启" : "关闭";
                        $(".audit_info_status").append(user_active);
                        $("#audit_pay_id").append(cash.id);
                        var audit_pay_id = $("#audit_pay_id").text();
                        $("#audit_time_start").append(cash.apply_time);
                        $("#audit_amount_apply").append(cash.amount);
                        $("#audit_wait").append(cash.waitamount);

                        if (cash_list.length > 0) {
                            /*打款详情列表*/
                            cash_list.forEach(function(item) {
                                $(".audit_list_rows").append(
                                    '<li>'+
                                    '<span>'+
                                    '<span class="audit_pay_id">'+item.cash_id+'</span>'+
                                    '<span class="audit_time_start">'+item.apply_time+'</span>'+
                                    '<span class="audit_amount_apply">'+item.amount+'</span>'+
                                    '<span class="audit_tran">0.00</span>'+
                                    '<span class="audit_wait">'+item.waitamount+'</span>'+
                                    '<span class="audit_pay_time"> - </span>'+
                                    '<span class="audit_pay_status">未打款</span>'+
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
                var cash_amount = $(this).parent().parent().children("td").get(5).innerText;
                var fans = $(this).attr("id");
                var productList = $("#audit_pay_tpl").text();
                bootbox.alert({
                    title: '<span class="text-success">打款进度</span>',
                    message: productList
                });
                $('#audit_pay_cash_id').append(cash_id);
                $('#audit_pay_fans_id').append(fans);
                $('.audit_amount_extract').append(cash_amount);
                $('.audit_amount_wait').append(cash_amount);
                $('#autit_alipay_account').val(autid_alipay_account[cash_id]);

            },
            'click .cash_wait': function()
            {
                bootbox.alert({
                    title: '<span class="text-success"></span>',
                    message: '系统自动打款中,请耐心等待.'
                });
            }
        };

        function getHeight() {
            return $(window).height() - $('.box-body').offset().top - 32;
        }

        initTable();

        $('#audit_form').validator().on('submit', function (e) {
            if(!e.isDefaultPrevented()){
                e.preventDefault();
            }
            $table.bootstrapTable('selectPage', 1);
        });
        $('#audit_download').click(function(){
            if (total_rows_audit > 0) {
                var audit_cash_id = $("input[name='audit_cash_id']").val();
                var audit_nickname = $("input[name='audit_nickname']").val();
                var audit_name = $("input[name='audit_name']").val();
                var audit_mobile = $("input[name='audit_mobile']").val();
                var audit_apply_time = $("input[name='audit_apply_time']").val();
                var url = "http://"+window.location.host+"/ajax/shop/fenxiao/cash/list?order=asc&load=1&status=0&audit_cash_id="+audit_cash_id+"&audit_nickname="+audit_nickname+"&audit_name="+audit_name+"&audit_mobile="+audit_mobile+"&audit_apply_time="+audit_apply_time;
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
            // autoclose: true,
            // language: 'zh-CN',
            format: 'yyyy-mm-dd'
        });
    });
    function MaskIt(obj){
        var hoverdiv = '<div class="divMask" style="position: absolute; width: 100%; height: 100%; left: 0px; top: 0px; background: #fff; opacity: 0; filter: alpha(opacity=0);z-index:5;"></div>';
        $(obj).wrap('<div class="position:relative;"></div>');
        $(obj).before(hoverdiv);
        $(obj).data("mask",true);
    }
</script>