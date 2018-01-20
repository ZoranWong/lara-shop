@extends('layouts.box_base_body')
@section('box-body')
<div class="radius-b">
  <div class="radius-r"><i class="fa fa-fw fa-check radius-g" id="radius-g-1"></i><div>买家下单</div>
  </div>
  <span id="created_at"></span>
  <div class="progress-r">
    <div class="progress progress-sm active progress-rm">
        <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
          <span class="sr-only">100</span>
        </div>
    </div>
  </div>
  <div class="radius-r"><i class="fa fa-fw fa-check radius-g" id="radius-g-2"></i><div>买家付款</div></div>
  <span id="paid_at"></span>
  <div class="progress-r">
    <div class="progress progress-sm active progress-rm">
        <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
          <span class="sr-only">100</span>
        </div>
    </div>
  </div>
  <div class="radius-r"><i class="fa fa-fw fa-check radius-g" id="radius-g-3"></i><div>商家发货</div></div>
  <span id="consigned_at"></span>
  <div class="progress-r">
    <div class="progress progress-sm active progress-rm">
        <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
          <span class="sr-only">100</span>
        </div>
    </div>
  </div>
  <div class="radius-r"><i class="fa fa-fw fa-check radius-g" id="radius-g-4"></i><div>确认收货</div></div>
  <span id="signed_at"></span>
</div>
<div class="row" style="margin-bottom: 20px;">
    <div class="col-xs-6">
        <div style="padding-left: 10px;">
            <div style="height:50px; line-height: 25px;">
                <h3>订单信息</h3>
                订单号：<span id="code"></span>
                买家：<span id="buyer"></span>
            </div>
            <hr>
            配送方式：<span id="post_type" style="height: 25px;"></span> <br>
            收货地址：<div id="targetData"><span id="receiver_address" style="height: 25px;"></span>,<span id="receiver_name"></span>, <span id="receiver_mobile"></span></div> <span id="copy_word" style="font-size:12px; color:#ab9a9a;">［复制］</span>
        </div>


    </div>
    <div class="col-xs-6">
        <div style="line-height: 15px;">
            <h3>订单状态：<span id="orderStatus"></span></h3>
            <p id="refundMoney"></p>
            <button class="btn btn-warning" id="close" style="display: none;">关闭订单</button>
            <button type="button" class="btn btn-block btn-primary btn-sm right" style="width: 80px; display: none;" id="send_goods">去发货</button>
        </div>
        <hr style="margin-top:7px;">
        <font color="orange">醉赞提醒：</font><span id="tip" style="height: 30px; line-height: 30px;"></span>
    </div>
    <!-- /.col -->
</div>
<style type="text/css">
    th{text-align: center;}
    .radius-g{position: absolute;font-size: 40px;top:10px;left:5px;color:#fff;z-index: 9;display:none}
    .radius-r{position: relative;width:58px;height:58px;float:left;background:#00a65a;border:1px solid #00a65a;border-radius: 35px;}
    .radius-r div{margin-top: -21px;}
    .radius-b span{position: absolute; margin-top: 65px; margin-left:-75px;}
    .radius-b{width:800px;height:110px;margin:0 auto; margin-top:23px;}
    .progress-rm{margin-top:25px}
    .progress-r{width:170px;height:60px;float:left;margin-left: -1px}

</style>
<!-- /.row -->
<div class="box-body">
    <table class="table" id="table">
        <tr  style="background:gainsboro;">
             <th style="width:450px; text-align: left;" colspan='2'><span style="margin-right: 75px;margin-left: 150px;">商品</span><span style="margin-right: 20px;margin-left: 102px;">价格</span></th>
            <th style="width:10%;">数量</th>
            <th style="width:19%;">小计（元）</th>
            <th style="width:19%;">状态</th>
        </tr>
        <tr>
            <td colspan="5" id="post_name" style="text-align: left; padding-left: 50px"></td>
        </tr>
    </table>
</div>
@stop
@push('js')
    <script type="text/javascript" src="{{ asset('js/zclip/jquery.zclip.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            var id =  {{ $id }};
            var inRefundflag = 0;
            //填充表单数据
            $.getJSON('/ajax/orders/detail/'+id,function (res) {
                var data = new Object();
                data.total = res.data.orders_item.length;
                data.rows = res.data.orders_item;
                var tableRows = 0;
                for(var i = 0; i< data.total; i++) {
                    tableRows += '<tr style=" font-size:12px;">';
                    tableRows += '<td colspan="2" style="text-align:left;"><img src="' + data.rows[i].merchandise_main_image_url + '" style="width:80px;height:80px;border-radius: 15%;margin-left:50px;" onerror=""><span style="width:215px; height:80px;  position:absolute;  padding-top:5px; text-align:center; font-size:13px;overflow: hidden;"><span style="width:200px;height: 35px;line-height: 17px;overflow: hidden;position: absolute;left: 15px;cursor:pointer;" title=' + data.rows[i].name + '>' + data.rows[i].name + '</span><span style="height:30px;overflow:hidden;position:absolute;top: 40px;line-height:  15px;left: 20px;right: 7px; cursor:pointer;" title='+ data.rows[i].sku_properties_name +'>' + data.rows[i].sku_properties_name +'</span></span>  <span style="position: absolute;margin-left: 206px;margin-top: 10px;text-align: center;width: 80px;height: 60px;padding-top: 17px;">' + data.rows[i].priceAmount +'</span></td>';
                    tableRows += '<td style="text-align:center;padding-top:35px;">' + data.rows[i].num + '</td>';
                    tableRows += '<td style="text-align:center;padding-top:35px;">' + data.rows[i].totalFeeAmount + '</td>';
                    switch(res.data.status)
                    {
                        case 'WAIT': var html = '待付款';break;
                        case 'PAID': var html = '待发货';break;
                        case 'SEND': var html = '待收货';break;
                        case 'COMPLETED': var html = '已完成';break;
                        case 'CANCEL': var html = '已取消';break;
                        case 'CLOSED': var html = '已关闭';break;
                    }
                    var readyChange = 1;
                    if(typeof(data.rows[i].refund_apply) != 'undefined' && data.rows[i].refund_apply.length) {
                        if(data.rows[i].refund_apply[0].status == 60) {
                            html = "<a href='/orders/refund/"+data.rows[i].id+"'>退款成功</a>";
                        }else if(data.rows[i].refund_apply[0].status != 70) {
                            html = "<a href='/orders/refund/"+data.rows[i].id+"'>退款中</a>";
                            inRefundflag = 1;
                        }
                        readyChange = 0;
                    }
                    tableRows += '<td style="text-align:center;padding-top:35px;" data-change='+readyChange+' class="signed_at">' + html + '</td>';
                    tableRows += '</tr>';
                }
                if(res.data.useCoupon){
                    tableRows += '<tr><td colspan="5" style="padding-left:20px;font-size:12px;color:darkgray;">附：该订单使用了以下优惠券</td></tr>';
                    tableRows += '<tr style="background:ghostwhite;"><td></td><td style="padding-left:90px;">优惠券名称</td><td></td><td></td><td>金额</td></tr>';
                    if(res.data.at_least){
                        var coupon_desc = res.data.coupon_name + '(满' + res.data.at_least + '元减' + res.data.value + '元)';
                    } else {
                        var coupon_desc = res.data.coupon_name + '(下单立减' + res.data.value + '元)';
                    }

                    tableRows += '<tr><td></td><td style="padding-left:90px;">' + coupon_desc + '</td><td></td><td></td><td>' + res.data.discountFeeAmount + '</td></tr>';
                }
                tableRows += '<tr><td></td><td></td><td></td><td style="padding-right:15px;text-align: right;" colspan="2">订单共' + data.total + '件商品，总计：' + res.data.paymentAmount + '( 含运费 ' + res.data.postFeeAmount + ')</td></tr>';
                $('#table').append(tableRows);
                $('#code').text(res.data.code);
                id = res.data.id;
                code = res.data.code;
                detail_address = res.data.receiver_detail_address;
                receiver_name = res.data.receiver_name;
                receiver_mobile = res.data.receiver_mobile;
                cancellation = res.data.cancel;
                $('#buyer').text(res.data.nickname);
                $('#receiver_name').text(res.data.receiver_name);
                $('#receiver_mobile').text(res.data.receiver_mobile);
                $('#receiver_address').text(res.data.receiver_detail_address);
                $('#post_type').text(res.data.post_name);
                $('#created_at').text(res.data.created_at);
                $('#paid_at').text(res.data.paid_at);
                $('#consigned_at').text(res.data.consigned_at);
                $('#signed_at').text(res.data.signed_at);
                targetData = $('#targetData').text();
                switch(res.data.status)
                {
                    case 'WAIT': var html = '等待买家付款';
                             var tip = '-请务必等待订单状态变更为“等待商家发货”后再进行发货。';
                             $('#close').show();break;
                    case 'PAID': var html = '买家已付款，等待商家发货';
                             var tip = '-请及时给用户发货，如有问题请联系用户协商处理';
                             $('#send_goods').show();break;
                    case 'SEND': var html = '商家已发货，等待交易成功';
                             var tip= "-请及时关注你发出的包裹状态，确保能配送至买家手中；\n-如果买家表示未收到货或者货物有问题，请及时联系买家积极处理，友好协商；";break;
                    case 'COMPLETED': var html = '已完成';
                             var tip = '交易完成，如果买家提出售后要求，请积极自行于买家协商，做好售后服务。';
                             var  string = '';
                             if(res.data.post_no){
                                string = '&nbsp;&nbsp;&nbsp;运单号: &nbsp;&nbsp;&nbsp;' + res.data.post_no;
                             }
                             var post_company = res.data.post_name + string;
                             $('#post_name').html(post_company);break;
                    case 'CANCEL': var html = '已取消';
                             var tip = (res.data.cancellation == 2) ? '卖家取消' : ((res.data.cancellation == 1) ? '买家取消' : ((res.data.cancellation == 3) ? '系统自动取消' : ''));break;
                    case 'CLOSED': var html = '已关闭';
                             var tip = (res.data.cancellation == 2) ? '卖家取消' : ((res.data.cancellation == 1) ? '买家取消' : ((res.data.cancellation == 3) ? '系统自动取消' : ''));break;
                }
                if(res.data.refunded_fee != 0) {
                    $('#refundMoney').append('订单退款金额：'+res.data.refunded_fee+' 元 <a href="/shop/order/refund/whereabouts/'+res.data.id+'">详情</a>');
                }
                $('#orderStatus').text(html);
                $('#tip').html(tip);
                //显示导向图步骤
                $('#radius-g-1').show();

                if(res.data.status == 'PAID'){
                    $('#radius-g-1,#radius-g-2').show();
                }
                if(res.data.status == 'SEND'){
                    $('#radius-g-1,#radius-g-2,#radius-g-3').show();
                }
                if(res.data.status == 'COMPLETED'){
                    $('#radius-g-1,#radius-g-2,#radius-g-3,#radius-g-4').show();
                }
            });
            $('#close').click(function(){
                if(confirm('确定关闭该订单吗？')){
                    $.post('/orders/cancel', {'id': id}, function(data){
                        if(data.code == 200) {
                            $.notify({
                                message: '关闭订单成功'
                            },{
                                type: 'info',
                                placement: {
                                    from: "top",
                                    align: "center"
                                },
                            });
                            $('#orderStatus').html('已取消');
                            $('#tip').text('卖家取消');
                            $('.signed_at').html('已取消');
                            $('#close').hide();
                        } else {
                            $.notify({
                                message: data.error
                            },{
                                type: 'danger',
                                placement: {
                                    from: "top",
                                    align: "center"
                                },
                            });
                        }
                    });
                }
            });
            $('#send_goods').click(function(){
                if(inRefundflag == 1) {
                bootbox.confirm({
                    title:'发货',
                    message:'本订单中的部分商品，买家已经提交退款申请，进行发货操作将关闭退款中的退款申请，是否继续？',
                    buttons:{
                        cancel: {
                            label:'取消',
                            className:"btn btn-primary"
                        },
                        confirm: {
                            label:"确定",
                            className:"btn btn-primary",
                        }
                    },
                    callback: sendGoodsFun
                });
            }else {
                sendGoodsFun(true);
            }
            function sendGoodsFun(result) {
                if(result) {
                    var deliverHtml = $('#send').text();
                        bootbox.dialog({
                            title: '<span class="text-danger">商品发货</span>',
                            message: deliverHtml,
                            buttons: {
                                Success: {
                                    label: "保存",
                                    className: "btn btn-primary pull-center-s sub-order",
                                    callback: function () {
                                        var post_type = $("input:radio[name='post_type']:checked").val();
                                        var post_name = '';
                                        var post_no = '';
                                        if(post_type == 10){
                                            var post_no = $.trim($("#d-post-no").val());
                                            var post_name = $("#post-name").val();
                                            var alertLog = '';
                                            if(post_name == ''){
                                                alertLog = '物流公司不能为空\n';
                                            }
                                            if(post_no.length == 0){
                                                alertLog += '物流单号不能为空';
                                            }
                                            if(post_no.length > 30){
                                                alertLog += '物流单号长度过长';
                                            }
                                            if(alertLog.length > 0){
                                                bootbox.alert({
                                                  title: '<span class="text-danger">提示</span>',
                                                  message: alertLog,
                                                });
                                                return false;
                                            }
                                        }
                                        $('.sub-order').attr('disabled', 'disabled');
                                        $('.sub-order').text('提交中...');
                                        $.post('/orders/consign/'+id, {post_type:post_type,post_no:post_no,post_name:post_name}, function (json) {
                                            if (json.code == 200) {
                                                $('#orderStatus').html('商家已发货，等待交易成功');
                                                $('#tip').text('-请及时关注你发出的包裹状态，确保能配送至买家手中；\n-如果买家表示未收到货或者货物有问题，请及时联系买家积极处理，友好协商；');
                                                $('.signed_at').each(function(){
                                                    if($(this).data('change') == 1) {
                                                        $(this).html('已发货');
                                                    }
                                                });
                                                $('#consigned_at').text(json.data.consigned_at);
                                                $('#radius-g-3').show();
                                                $('#send_goods').hide();
                                                if(post_type == 10) {
                                                    $('#post_type').text(post_name);
                                                    var post_company = post_name + '&nbsp;&nbsp;&nbsp;运单号: &nbsp;&nbsp;&nbsp;' + post_no;
                                                    $('#post_name').html(post_company);
                                                }

                                                $.notify({
                                                    message: "订单发货成功"
                                                },{
                                                    type: 'success',
                                                    placement: {
                                                        from: "top",
                                                        align: "center"
                                                    },
                                                });
                                            } else if (json.code == 401) {
                                                location.pathname = '/login';
                                            } else {
                                                bootbox.alert({
                                                    title: '<span class="text-danger">错误</span>',
                                                    message: '发货失败，请重新发货',
                                                });
                                                $('.sub-order').removeAttr('disabled');
                                                $('.sub-order').text('确定');
                                                return false;
                                            }
                                        },'json');
                                    }
                                }
                            }
                        });

                    }
                }
            });

            $('#copy_word').zclip({
                path: "{{asset('js/zclip/ZeroClipboard.swf')}}",
                copy: function(){
                    return targetData;
                },
                beforeCopy:function(){/* 按住鼠标时的操作 */
                    $(this).css("color","orange");
                },
                afterCopy:function(){/* 复制成功后的操作 */
                    $(this).css("color","green");
                    $(this).text('复制成功');
                }
            });
        });
    </script>

    <!-- 发货模板 -->
    <script type="text/template" id="send">
        <!-- /*查看某商品独立佣金详情 */ -->
        <form class="form-horizontal" submit="return false;" id="order-form">
            <div class="box-body">
                <div class="form-group">
                    <label for="d-post-type" class="col-sm-2 control-label">订单编号:</label>
                    <div class="col-sm-6" id="order_number">

                    </div>
                </div>
                <div class="form-group">
                    <label for="d-post-type" class="col-sm-2 control-label">收货地址:</label>
                    <div class="col-sm-10" id="detail_address">

                    </div>
                </div>
                <div class="form-group">
                    <label for="d-post-type" class="col-sm-2 control-label">发货方式:</label>
                    <div class="col-sm-8">
                        <span class="form-control" style="border:none">
                            <input type="radio" class="post-chose" name="post_type" value="10" checked>物流发货&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" class="post-chose" name="post_type" value="20">无需物流
                        </span>
                    </div>
                </div>
                <div class="form-group" id="post-form">
                    <label for="d-post-no" class="col-sm-2 control-label">物流公司:</label>
                    <div class="col-sm-10">
                        <div style="float:left;width:130px">
                            <select class="form-control" id="post-name">
                                <option value="">请选择物流</option>'
                                <option value="顺丰快递">顺丰快递</option>
                                <option value="申通快递">申通快递</option>
                                <option value="圆通快递">圆通快递</option>
                                <option value="韵达快递">韵达快递</option>
                                <option value="天天快递">天天快递</option>
                                <option value="EMS">EMS</option>
                                <option value="中国邮政">中国邮政</option>
                                <option value="中通快递">中通快递</option>
                                <option value="国通快递">国通快递</option>
                                <option value="其他">其他</option>
                            </select>
                        </div>
                        <div style="float:left;width:300px;margin-left:5px">
                            <span style="float:left;line-height:34px">
                                <strong>快递单号：</strong>
                            </span><input type="text" style="float:left;width:180px" class="form-control" id="d-post-no" placeholder="请输入单号">
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <script type="text/javascript">
            $("body").bind('click','.post-chose',function(e){
                if(e.target.className != 'post-chose')return;
                var postType = $("input:radio[name='post_type']:checked").val();
                if(postType == 10){
                  $("#post-form").show();
                }
                if(postType == 20){
                  $("#post-form").hide();
                }
              });
            $('#order_number').text(code);
            $('#detail_address').text(detail_address + ',  ' + receiver_name + ',  ' + receiver_mobile);
        </script>
    </script>
@endpush
