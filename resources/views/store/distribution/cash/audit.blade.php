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
           data-url="/ajax/distribution/cash/list?status=0&store_id={{$store_id}}"
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

<script type="text/template" id="audit_tpl">
    @include('store.distribution.cash.audit_tpl')
</script>

<script type="text/template" id="audit_pay_tpl">
    @include('store.distribution.cash.audit_pay_tpl')
</script>

<script>
    let total_rows_audit = 0;
    function closeWindows()
    {
        if (navigator.userAgent.indexOf("Firefox") !== -1 || navigator.userAgent.indexOf("Chrome") !== -1)
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
        let autid_alipay_account = new Array();
        let $table = $('#audit_table'),
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
                            field: 'head_image_url',
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
                    let ree = res.data['rows'];
                    ree.forEach(function(hj) {
                        autid_alipay_account[parseInt(hj['id'])] = hj['alipay_account'];
                        hj['audit_cash_id']=hj['id'];
                        if(hj['head_image_url'] != null) {
                            hj['head_image_url'] = "<img src='"+hj['head_image_url']+"' style='width:30px;height: 30px;' />";
                        } else {
                            hj['head_image_url'] = "<img src='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAoAAAAFCAYAAAB8ZH1oAAAALUlEQVQImWP8DwQMRAAWCPWWYWOeO0PzMWSpGIZ5ZwoY9KA8RmJNZCJGEUkKAXh/DgMb8RMjAAAAAElFTkSuQmCC' style='width:2px;height: 2px;' />";
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
                    let arr = ['audit_cash_id','audit_nickname','head_image_url','audit_name','audit_mobile','amount','audit_apply_time'];
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
            let type=row.status;
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
            let opa = row.user_id;
            let status = row.status;
            let operateDate = "";
            if (status === 3) {
                operateDate = [
                    '<a class="cash_wait" href="javascript:void(0)" title="打款中" style="margin-left: 10px;"  id="'+opa+'"> 打款中 </a>  ',
                ];
            } else {
                operateDate = [
                    '<a class="cash" href="javascript:void(0)" title="打款" style="margin-left: 10px;"  id="'+opa+'"> 打款 </a>  ',
                ];
            }

            return operateDate.join('');
        }

        window.operateEvents = {
            /*详情页 弹出框 内容*/
            'click .detail': function()
            {
                let cash_id = $(this).parent().parent().children("td").get(0).innerHTML;
                let fans = $(this).attr("id");
                $.post('/ajax/distribution/cash/detail?status=0', {'cash_id':cash_id,'fans_id':fans}, function (json)
                {
                    if(json.code=200)
                    {
                        let data=json.data;
                        let cash = data.cash;
                        if (cash == null) {
                            return false;
                        }
                        if(cash.commission_settings == null) {
                            cash.commission_settings['father_commission'] = 0;
                            cash.commission_settings['grand_father_commission'] = 0;
                            cash.commission_settings['great_grand_father_commission'] = 0;
                        }
                        let user = data.user;
                        let cash_list = cash.cash_details;
                        let pay_time = cash.verify_time;

                        let productList = $("#audit_tpl").text();
                        bootbox.alert({
                            title: '<span class="text-success">提现详情</span>',
                            message: productList
                        });
                        /*个人基本详情*/
                        $(".audit_per_img").attr('src',user.head_image_url);
                        $(".audit_nickname").append(user.nickname);
                        $(".audit_username").append(user.full_name);
                        $(".audit_user_id").append(user.user_id);
                        $(".audit_phone").append(user.mobile);
                        $(".audit_wechat").append(user.wechat);
                        if (cash.type === 1) {//  支付宝打款
                            $(".audit_alipay_account").append("提现账号: 支付宝 <span id='audit_pay_tel'>"+cash.alipay_account+"<"+"/span>");
                        }
                        $(".audit_one_per").append(data.user_one+"人");
                        $(".audit_two_per").append(data.user_two+"人");
                        $(".audit_thr_per").append(data.user_thr+"人");
                        //  根据分销层级 对应展示相关数据
                        if (data.level === 2) {
                            $(".audit_div_left_thr").empty();
                            $('.audit_thr_com').parent().remove();
                            data.user_thr = 0;
                        } else if (data.level === 1) {
                            $(".audit_div_left_two").empty();
                            $(".audit_div_left_thr").empty();
                            $('.audit_thr_com').parent().remove();
                            $('.audit_two_com').parent().remove();
                            data.user_two = 0;
                            data.user_thr = 0;
                        } else if (data.level === 0) {
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
                        let audit_total_per = parseInt(data.user_one) +parseInt(data.user_two) +parseInt(data.user_thr);
                        $(".audit_total_per").append(audit_total_per+"人");
                        $(`.audit_one_com`).append(cash.commission_settings['father_commission']+"%");
                        $(`.audit_two_com`).append(cash.commission_settings['grand_father_commission']+"%");
                        $(`.audit_thr_com`).append(cash.commission_settings['great_grand_father_commission']+"%");
                        let user_active = user.is_active;
                        user_active = user_active == 1 ? "开启" : "关闭";
                        $(".audit_info_status").append(user_active);
                        $(`#audit_pay_id`).append(cash.id);
                        let audit_pay_id = $("#audit_pay_id").text();
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
                            let children = $(this).parent('li.parent_li').find(' > ul > li');
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
                            let childrens = $(`.tree li.parent_li > span`).parent('li.parent_li').find(' > ul > li');
                            childrens.hide('fast');
                            $(`.tree li.parent_li > span`).attr('title', '查看详情').find(' > i').addClass('icon-plus-sign').removeClass('icon-minus-sign');
                        }
                        hidden_ul();
                    }
                }, 'json');
            },
            'click .cash': function()
            {
                let cash_id = $(this).parent().parent().children("td").get(0).innerHTML;
                let cash_amount = $(this).parent().parent().children("td").get(5).innerText;
                let fans = $(this).attr("id");
                let productList = $("#audit_pay_tpl").text();
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
                let audit_cash_id = $("input[name='audit_cash_id']").val();
                let audit_nickname = $("input[name='audit_nickname']").val();
                let audit_name = $("input[name='audit_name']").val();
                let audit_mobile = $("input[name='audit_mobile']").val();
                let audit_apply_time = $("input[name='audit_apply_time']").val();
                let url = "http://"+window.location.host+"/ajax/shop/fenxiao/cash/list?order=asc&load=1&status=0&audit_cash_id="+audit_cash_id+"&audit_nickname="+audit_nickname+"&audit_name="+audit_name+"&audit_mobile="+audit_mobile+"&audit_apply_time="+audit_apply_time;
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
        let hoverdiv = '<div class="divMask" style="position: absolute; width: 100%; height: 100%; left: 0px; top: 0px; background: #fff; opacity: 0; filter: alpha(opacity=0);z-index:5;"></div>';
        $(obj).wrap('<div class="position:relative;"></div>');
        $(obj).before(hoverdiv);
        $(obj).data("mask",true);
    }
</script>
