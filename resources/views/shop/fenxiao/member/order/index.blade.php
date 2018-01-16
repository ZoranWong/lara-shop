@extends('layouts.my_page')
@section('content')
    <div id="toolbar">
        <form class="form-horizontal" id="form" action="ajax/shop/fenxiao/member/list">
            <div class="col-md-3">
                <div class="input-group col-md-12">
                    <div class="input-group-addon">订单号</div>
                    <input type="text" class="form-control input" name="order_number" placeholder="ID" maxlength="60">
                </div>
            </div>
            <div class="col-md-3">
                <div class="input-group col-md-12">
                    <div class="input-group-addon">昵称</div>
                    <input type="text" class="form-control input" name="nickname" placeholder="买家昵称搜索" maxlength="60">
                </div>
            </div>
            <div class="col-md-3">
                <div class="input-group col-md-12">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" name="order_created_start" class="form-control pull-right datetimepicker" placeholder="下单开始时间" readonly>
                </div>
            </div>
            <div class="col-md-3">
                <div class="input-group col-md-12">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" name="order_created_end" class="form-control pull-right datetimepicker" placeholder="下单结束时间" readonly>
                </div>
            </div>
            <div class="col-md-12" style="height: 15px;"></div>
            <div class="col-md-3">
                <div class="input-group col-md-12">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" name="commission_time_start" class="form-control pull-right datetimepicker" placeholder="佣金结算开始时间" readonly>
                </div>
            </div>
            <div class="col-md-3">
                <div class="input-group col-md-12">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" name="commission_time_end" class="form-control pull-right datetimepicker" placeholder="佣金结算结束时间" readonly>
                </div>
            </div>
            <div class="col-md-3">
                <div class="input-group col-md-12">
                    <div class="input-group-addon">佣金状态</div>
                    <select class="select form-control" name="commission_status">
                        <option value="">佣金状态</option>
                        <option value="1"> 未结算 </option>
                        <option value="2"> 已结算 </option>
                        <option value="3"> 已退单 </option>
                    </select>
                </div>
            </div>
            <div class="form-group col-md-1" style="float: right;">
                <button type="reset" class="btn btn-primary" name="reset">重置</button>
            </div>
            <div class="col-md-1" style="float: right;margin-left: 15px;">
                <button type="submit" class="btn btn-primary">搜索</button>
            </div>
            <div class="col-md-1" style="float: right;">
                <button type="button" class="btn btn-default load">导出Excel</button>
            </div>
        </form>
    </div>
    <div class="box-body">
        <table id="table"
               data-toolbar="#toolbar"
               data-pagination="true"
               data-id-field="fans_id"
               data-page-size="10"
               data-page-list="[10, 25, 50, 100]"
               data-show-footer="false"
               data-side-pagination="server"
               data-query-params="queryParams"
               data-url="/ajax/shop/fenxiao/member/order/{{ $id }}"
               data-response-handler="responseHandler">
        </table>
    </div>
    <style>
        .fixed-table-container {
            min-height:278px;
        }
    </style>
@stop
@section('js')
    <script type="text/javascript">
        var fans_id = {{ $id }};
        /*当前订单总数*/
        var total_rows = 0;
        var $table = $('#table');
        function initTable() {
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
                            align: 'center',
                            valign: 'middle'
                        }, {
                            field: 'nickname',
                            title: '买家昵称',
                            align: 'center',
                            valign: 'middle'
                        }, {
                            valign: 'middle',
                            field: 'order_created_at',
                            title: '下单时间',
                            align: 'center'
                        }, {
                            field: 'order_completed_at',
                            title: '完成时间',
                            align: 'center',
                            valign: 'middle'
                        }, {
                            field: '佣金',
                            title: '佣金',
                            align: 'center',
                            valign: 'middle',
                            formatter: getCommission
                        }, {
                            field: 'should_settled_at',
                            valign: 'middle',
                            title: '结算时间',
                            editable: true,
                            align: 'center'
                        }, {
                            field: 'commissionStatus',
                            title: '佣金状态',
                            editable: true,
                            align: 'center',
                            valign: 'middle',
                            formatter: getCommissionStatus
                        }
                    ]
                ],
                responseHandler: function (res) {
                    total_rows = res.data['total'];
                    return res.data;
                },
                'queryParams': function(params){
                    var arr = ['order_number','nickname','full_name','mobile','order_created_at','settled_at','order_created_start','order_created_end','commission_time_start','commission_time_end','commission_status'];
                    arr.forEach(function(item){
                        params[item] = $('[name='+item+']').val()
                    });
                    return params;
                }
            });
            function getHeight() {
                return $(window).height() - $('.box-body').offset().top - 32;
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
        $('.load').click(function(){
            if (total_rows > 0) {
                var order_number = $("input[name='order_number']").val();
                var nickname = $("input[name='nickname']").val();
                var order_created_start = $("input[name='order_created_start']").val();
                var order_created_end = $("input[name='order_created_end']").val();
                var commission_time_start = $("input[name='commission_time_start']").val();
                var commission_time_end = $("input[name='commission_time_end']").val();
                var commission_status = $("select[name='commission_status']").val();
                var url = "http://" + window.location.host + "/ajax/shop/fenxiao/member/order/"+fans_id+"?load=1&order_number="+order_number+"&nickname="+nickname+"&order_created_start="+order_created_start+"&order_created_end="+order_created_end+"&commission_time_start="+commission_time_start+"&commission_time_end="+commission_time_end+"&commission_status="+commission_status;
                window.open(url);
            } else {
                bootbox.alert({
                    title: '<span class="text-danger">ERROR!</span>',
                    message: '没有记录,导出EXCEL失败!'
                });
            }
        });
        function getCommission(value, row, index){
            var html = "";
            /*佣金状态是否冻结: 0否 1是*/
            if (row.commission_status > 0) {
                html += "<span style='color:#FF0000;'>【冻结】</span>";
            }
//        if(row.level == 0) {
//            html +=  '自购：' + row.commission;
//        } else {
//             html += row.level+'级：' + row.commission;
//             if( row.refunded_fee >0 ){
//                html += '(已退款' + row.refunded_fee + ')';
//             }
//        }
            if(row.fans_id == fans_id) {
                html +=  '自购：' + row.commission;
            } else if(row.father_id == fans_id) {
                html +=  '一级：' + row.commission;
            } else if(row.grand_father_id == fans_id) {
                html +=  '二级：' + row.commission;
            } else if(row.great_grand_father_id == fans_id) {
                html +=  '三级：' + row.commission;
            }
            if (row.refunded_fee > 0) {
                html += "（已退款"+row.refunded_fee+"）";
            }
            return html;
        }
        function getCommissionStatus(value, row, index) {
            var html = "";
            switch (row.commission_settle_status) {
                case 0:html = "未结算";break;
                case 1:html = "已结算";break;
                case 2:html = "已退单";break;
            }
            return html;
        }
        initTable();
        $('#form').validator().on('submit', function (e) {
            if(!e.isDefaultPrevented()){
                e.preventDefault();
            }
            $table.bootstrapTable('selectPage', 1)
        });
        // 日期控件
        $('.datetimepicker').datetimepicker({
            autoclose: true,
            language: 'zh-CN',
            format: 'yyyy-mm-dd'
        });
    </script>
@stop