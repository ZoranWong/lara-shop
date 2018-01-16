@extends('shop.fenxiao.layouts')
@section('tab_content')
    <div id="toolbar">
        <form class="form-horizontal" id="form">
            <div class="form-group col-md-3">
                <div class="input-group  col-md-12">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" name="order_created_at" class="form-control pull-right datetimepicker" placeholder="下单起始时间" readonly>
                </div>
            </div>
            <div class="form-group col-md-3">
                <div class="input-group  col-md-12">
                    {{--<div class="input-group-addon">时间范围</div>--}}
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text"  class="form-control pull-right datetimepicker" name="heji" placeholder="下单结束时间" readonly>
                </div>
            </div>
            <div class="form-group col-md-2">
                <div class="input-group col-md-12">
                    <input type="text" class="form-control input" name="order_number" placeholder="订单号" maxlength="60">
                </div>
            </div>
            <div class="form-group col-md-2">
                <div class="input-group  col-md-12">
                    <input type="text" class="form-control input" name="mobile" placeholder="手机号" maxlength="11">
                </div>
            </div>
            <div class="form-group col-md-3">
                <div class="input-group col-md-12">
                    <div class="input-group-addon">佣金状态</div>
                    <select class="select form-control" name="status" id="status">
                        <option value="">佣金状态</option>
                        <option value="1"> 未结算 </option>
                        <option value="2"> 已结算 </option>
                        <option value="3"> 已退单 </option>
                    </select>
                </div>
            </div>
            <div class="form-group col-md-1">
                <button type="submit" class="btn btn-primary">搜索</button>
            </div>
            <div class="form-group col-md-1">
                <button type="reset" class="btn btn-primary" name="reset">重置</button>
            </div>
            <div class="form-group col-md-1 margin_left">
                <button type="button" class="btn btn-primary" id="order-download">导出</button>
            </div>
        </form>
    </div>

    <div class="box-body" id="fenxiao_box">
        <table id="table"
               data-toolbar="#toolbar"
               data-pagination="true"
               data-id-field="id"
               data-page-size="10"
               data-page-list="[10, 25, 50, 100]"
               data-show-footer="false"
               data-side-pagination="server"
               data-query-params="queryParams"
               data-url="/ajax/shop/fenxiao/orderlist"
               data-response-handler="responseHandler">
        </table>
    </div>
    <style>
        .fixed-table-container {
            min-height:278px;
        }
    </style>

    <!-- /.box-body -->
@stop
@section('js')

    <script language="javascript" type="text/javascript" src="http://vip.fenxiao.zuizan100.com.cn/statics/js/artDialog/artDialog.js" charset="UTF-8"></script>
    <script language="javascript" type="text/javascript" src="http://vip.fenxiao.zuizan100.com.cn/statics/js/artDialog/plugins/iframeTools.js" charset="UTF-8"></script>
    <script language="javascript" type="text/javascript" src="http://vip.fenxiao.zuizan100.com.cn/statics/js/artDialog/artDialogUtils.js" charset="UTF-8"></script>

    <link href="http://vip.fenxiao.zuizan100.com.cn/statics/css/dialog.css" rel="stylesheet" type="text/css">

    <script>

        var total_rows = 0;
        var OnClick = 0;
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
            var $table = $('#table'),
                    $remove = $('#remove'),
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
                    striped: true,
                    height: getHeight(),
                    columns: [
                        [
                            {
                                field: 'order_number',
                                title: '订单编号',
                                valign: 'middle',
                                align: 'center',
                                events: operateEvents,
                                formatter: orderFormatter
                            },{
                                field: 'weapp_nickname',
                                title: '买家',
                                valign: 'middle',
                                align: 'center'
                            },{
                                field: 'order_created_at',
                                title: '下单时间',
                                valign: 'middle',
                                align: 'center'
                            },{
                                field: 'should_settled_at',
                                title: '结算时间',
                                valign: 'middle',
                                align: 'center'
                            }, {
                                valign: 'middle',
                                field: 'product_price',
                                title: '总金额',
                                editable: true,
                                align: 'center'
                            },  {
                                field: 'heji',
                                valign: 'middle',
                                title: '合计佣金',
                                align: 'center',
                                events: operateEvents,
                                formatter: commissionFormatter
                            }, {
                                field: 'mobile',
                                title: '手机号',
                                align: 'center',
                                valign: 'middle'
                            },  {
                                field: 'status',
                                title: '订单状态',
                                editable: true,
                                valign: 'middle',
                                align: 'center',
                                formatter:statusType
                            }, {
                                field: 'commission_settle_status',
                                title: '佣金状态',
                                editable: true,
                                valign: 'middle',
                                align: 'center',
                                formatter:commissionType
                            }
                        ]
                    ],
                    /*获取数据*/
                    responseHandler: function (res)
                    {
                        total_rows = res.data['total'];
                        var ree = res.data['rows'];
                        ree.forEach(function(hj) {
                            /*计算佣金总金额*/
                            var heji = 0;
                            var commission = 0;
                            var father_commission = 0;
                            var grand_father_commission = 0;
                            var great_grand_father_commission = 0;
                            hj['commission'] = hj.commission *100;
                            if (hj.commission_status == 0){
                                heji += hj['commission'];
                            }
                            if (hj.father_id > 0 && hj.father_commission_status == 0){
                                heji += hj.father_commission * 100;
                            }
                            if (hj.grand_father_id > 0 && hj.grand_father_commission_status == 0){
                                heji += hj.grand_father_commission * 100;
                            }
                            if (hj.great_grand_father_id > 0 && hj.great_grand_father_commission_status == 0){
                                heji += hj.great_grand_father_commission * 100;
                            }
                            hj['heji'] = toDecimal(heji / 100);
                            hj['mobile'] = hj.member_weapp['mobile'];
                            hj['product_price'] = (hj['order_payment'] / 100);
                            hj['full_name'] = hj.member_weapp['full_name'];
                        });
                        return res.data;
                    },
                    /*分页列表 查询*/
                    'queryParams': function(params)
                    {
                        var arr = ['order_number','full_name','order_created_at','settle_at','product_price','heji','mobile','status','commission_settle_status'];
                        arr.forEach(function(item)
                        {
                            params[item] = $('[name='+item+']').val()
                        });
                        return params;
                    }
                });
                /*多选框 用于多选删除*/
                $table.on('check.bs.table uncheck.bs.table ' +
                        'check-all.bs.table uncheck-all.bs.table', function ()
                {
                    $remove.prop('disabled', !$table.bootstrapTable('getSelections').length);
                    selections = getIdSelections();
                });

                $remove.click(function ()
                {
                    //批量删除
                });
                /*订单删除 获取ID*/
                function getIdSelections() {
                    return $.map($table.bootstrapTable('getSelections'), function (row) {
                        return row.order_number;
                    });
                }
                /*订单删除 获取名称*/
                function getNameSelections() {
                    return $.map($table.bootstrapTable('getSelections'), function (row) {
                        return row.full_name;
                    });
                }

                setTimeout(function () {
                    $table.bootstrapTable('resetView');
                }, 200);

                $(window).resize(function () {
                    $table.bootstrapTable('resetView', {
                        height: getHeight()
                    });
                });
            }

            /*分销 订单列表 订单状态*/
            function statusType(value, row, index)
            {
                var type=row.status;
                switch(type)
                {
                    case 0:
                        return "未完成";
                        break;
                    case 1:
                        return "待发货";
                        break;
                    case 2:
                        return "已发货";
                        break;
                    case 3:
                        return "已完成";
                        break;
                    case 4:
                        return "退款中";
                        break;
                    case 5:
                        return "已关闭";
                        break;
                        defaule:
                                return "";
                        break;
                }
            }
            /*分销 订单列表 佣金状态*/
            function commissionType(value, row, index) {
                var type = row.commission_settle_status;
                switch (type) {
                    case 0:
                        return "未结算";
                        break;
                    case 1:
                        return "已结算";
                        break;
                    case 2:
                        return "已退单";
                        break;
                        defaule:
                                return "已退单";
                        break;
                }
            }
            /*详情页 弹出框按钮*/
            function orderFormatter(value, row, index)
            {
                var opa = row.order_number;
                var orderDate = ['<a class="order_detail" href="javascript:void(0)" title="订单详情" id='+opa+'>'+opa+'</a>'];
                return orderDate.join('');
            }

            function commissionFormatter(value, row, index)
            {
                var opa = row.order_number;
                var total_commission = row.heji;
                var commissionDate = ['<a class="commission_detail" href="javascript:void(0)" title="佣金详情" id='+opa+'>'+total_commission+'</a>'];
                return commissionDate.join('');
            }

            window.operateEvents = {
                /*详情页 弹出框 内容*/
                'click .order_detail': function(row)
                {
                    var oid = $(this).attr("id");
                    $.post('/ajax/shop/fenxiao/detail', {'detail': oid}, function (json)
                    {
                        if(json.code=200)
                        {
                            var type=eval(json.data);
                            var tab;
                            if(type.message=true)
                            {
                                /*订单详情   遍历商品*/
                                var shoptype;
                                tab ='<table class="row" style="text-align: center;margin: 0 auto;width: 100%;"  >';
                                tab += '<tr id="row" class="row_class_order" style="margin: 0 auto;text-align: center;"><td class="">商品名称</td><td class="">商品数量</td><td class="">商品总价</td><td class="">分销佣金</td><td class="">商品状态</td></tr>';
                                var order = type.rows;
                                var items = order.items;
                                var total_commission;
                                items.forEach(function(type) {
                                    /*结算金额*/
                                    total_commission = 0;
                                    if (order.commission_status == 0) {
                                        total_commission += toThousands(type.commission);
                                    }
                                    if (order.father_commission_status == 0) {
                                        total_commission += toThousands(type.father_commission);
                                    }
                                    if (order.grand_father_commission_status == 0) {
                                        total_commission += toThousands(type.grand_father_commission);
                                    }
                                    if (order.great_grand_father_commission_status == 0) {
                                        total_commission += toThousands(type.great_grand_father_commission);
                                    }
                                    total_commission = total_commission / 100;
                                    /*结算状态*/
                                    shoptype = type.status == 0 ? "正常" : "退款作废";
                                    tab += '<tr id="row" class="row_class_order" style="margin: 0 auto;text-align: center;"><td class="">'+type.product_name+'</td><td class="">'+type.product_num+'</td><td class="">'+type.payment+'</td><td class="">'+total_commission+'</td><td class="">'+shoptype+'</td></tr>';
                                });
                                tab += '</table>';
                            }
                            else
                            {
                                tab="ERROR";
                            }

                            bootbox.alert({
                                title: '<span class="text-success">商品详情</span>',
                                message: tab
                            });
                        }
                    }, 'json');
                },
                'click .commission_detail': function(row)
                {
                    var tab;
                    var oid = $(this).attr("id");
                    var val = $(this).html();
                    /*如果佣金为0 则提示没有产生佣金*/
                    if (val == 0) {
                        tab = '<table class="row" style="text-align: center;margin: 0 auto;width: 100%;"><tr id="row" class="row_class_order" style="margin: 0 auto;text-align: center;"><td class="">当前交易没有产生佣金</td></tr></table>';
                        bootbox.alert({
                            title: '<span class="text-danger">佣金详情</span>',
                            message: tab
                        });
                        return false;
                    }
                    $.post('/ajax/shop/fenxiao/detail', {'detail': oid}, function (json)
                    {
                        if(json.code=200)
                        {
                            var type=eval(json.data);
                            if(type.message=true)
                            {
                                var order = type.rows;
                                var items = order.items;
                                var users = type.user;
                                var total_commission;

                                /*自购佣金总额*/
                                var fans_commission = 0;
                                /*一级分销佣金总额*/
                                var father_commission = 0;
                                /*二级分销佣金总额*/
                                var grand_father_commission = 0;
                                /*三级分销佣金总额*/
                                var great_grand_father_commission = 0;
                                /*分销商名称(自购)*/
                                var fans_name = '';
                                /*一级分销商名称*/
                                var father_name = '';
                                /*二级分销商名称*/
                                var grand_father_name = '';
                                /*三级分销商名称*/
                                var great_grand_father_name = '';
                                users.forEach(function(user){
                                    if(user.weapp_user_id == order.weapp_user_id) {
                                        fans_name = user.full_name;
                                    }
                                    if(user.weapp_user_id == order.father_id) {
                                        father_name = user.full_name;
                                    }
                                    if(user.weapp_user_id == order.grand_father_id){
                                        grand_father_name = user.full_name;
                                    }
                                    if(user.weapp_user_id == order.great_grand_father_id){
                                        great_grand_father_name = user.full_name;
                                    }
                                });

                                var fans_status = "";
                                var father_status = "";
                                var grand_father_status = "";
                                var great_grand_father_status = "";

                                var fans_hidden = "";
                                var father_hidden = "";
                                var grand_father_hidden = "";
                                var great_grand_father_hidden = "";

                                if (order.commission_status > 0)  {
                                    fans_status = "<span style='color:#d3d3d3;'>(冻结)</span>";
                                }
                                if (!order.weapp_user_id) {
                                    fans_hidden = "hidden";
                                }
                                if (order.father_commission_status > 0) {
                                    father_status = "<span style='color:#d3d3d3;'>(冻结)</span>";
                                }
                                if (!order.father_id) {
                                    father_hidden = "hidden";
                                }
                                if (order.grand_father_commission_status > 0) {
                                    grand_father_status = "<span style='color:#d3d3d3;'>(冻结)</span>";
                                }
                                if (!order.grand_father_id) {
                                    grand_father_hidden = "hidden";
                                }
                                if (order.great_grand_father_commission_status > 0) {
                                    great_grand_father_status = "<span style='color:#d3d3d3;'>(冻结)</span>";
                                }
                                if (!order.great_grand_father_id) {
                                    great_grand_father_hidden = "hidden";
                                }
                                tab = '<table class="row" style="text-align: center;margin: 0 auto;width: 100%;"  >';
                                tab += '<tr id="row" class="row_class_order" style="margin: 0 auto;text-align: center;"><td class="">分销商</td><td class="">分销商等级</td><td class="">对应佣金</td></tr>';
                                tab = '<table class="row" style="text-align: center;margin: 0 auto;width: 100%;"  >';
                                tab += '<tr id="row" class="row_class_order" style="margin: 0 auto;text-align: center;"><td class="">分销商</td><td class="">分销商等级</td><td class="">对应佣金</td></tr>';
                                fans_commission = order.commission;
                                tab += '<tr id="row" class="row_class_order" style="margin: 0 auto;text-align: center;"'+fans_hidden+'><td class="">'+fans_name+'</td><td class="">自购</td><td class="">'+fans_commission+fans_status+'</td></tr>';
                                father_commission = order.father_commission;
                                tab += '<tr id="row" class="row_class_order" style="margin: 0 auto;text-align: center;"'+father_hidden+'><td class="">'+father_name+'</td><td class="">一级分销商</td><td class="">'+father_commission+father_status+'</td></tr>';
                                grand_father_commission = order.grand_father_commission;
                                tab += '<tr id="row" class="row_class_order" style="margin: 0 auto;text-align: center;"'+grand_father_hidden+'><td class="">'+grand_father_name+'</td><td class="">二级分销商</td><td class="">'+grand_father_commission+grand_father_status+'</td></tr>';
                                great_grand_father_commission = order.great_grand_father_commission;
                                tab += '<tr id="row" class="row_class_order" style="margin: 0 auto;text-align: center;"'+great_grand_father_hidden+'><td class="">'+great_grand_father_name+'</td><td class="">三级分销商</td><td class="">'+great_grand_father_commission+great_grand_father_status+'</td></tr>';
                                tab += '</table>';
                            }
                            else
                            {
                                tab="ERROR";
                            }

                            bootbox.alert({
                                title: '<span class="text-success">佣金详情</span>',
                                message: tab
                            });
                        }
                    }, 'json');
                }
            };

            function getHeight() {
                return $(window).height() - $('#fenxiao_box').offset().top - 32;
            }

            initTable();

            $('#form').validator().on('submit', function (e) {
                if(!e.isDefaultPrevented()){
                    e.preventDefault();
                }
                $table.bootstrapTable('selectPage', 1);
            });
            /*导出EXCEL*/
            $('#order-download').click(function(){
                if (total_rows > 0) {
                    var order_created_at = $("input[name='order_created_at']").val();
                    var heji = $("input[name='heji']").val();
                    var order_number = $("input[name='order_number']").val();
                    var mobile = $("input[name='mobile']").val();
                    var status = $('#status').val();
                    var url = "http://"+window.location.host+"/ajax/shop/fenxiao/orderlist?load=0&order=asc&load=1&status="+status+"&mobile="+mobile+"&order_number="+order_number+"&heji="+heji+"&order_created_at="+order_created_at;
                    window.open(url);
                } else {
                    bootbox.alert({
                        title: '<span class="text-danger">ERROR!</span>',
                        message: '没有记录,导出EXCEL失败!',
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
        function toThousands(num) {
            if (num == 0) {
                return 0;
            }
            num = num.toString();
            str=num.replace(/[/,|/.]/g,'');
            return Number(str);
        }
        function toDecimal(x) {
            var f = parseFloat(x);
            if (isNaN(f)) {
                return false;
            }
            var f = Math.round(x*100)/100;
            var s = f.toString();
            var rs = s.indexOf('.');
            if (rs < 0) {
                rs = s.length;
                s += '.';
            }
            while (s.length <= rs + 2) {
                s += '0';
            }
            return s;
        }
    </script>
@stop
