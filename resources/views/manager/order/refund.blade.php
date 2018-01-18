@extends('my.box_base')
@section('box-body')
<style type="text/css">
    th{text-align: center;}
    .radius-g{position: absolute;font-size: 40px;top:10px;left:5px;color:#fff;z-index: 9;display:none}
    .radius-r{position: relative;width:58px;height:58px;float:left;background:#00a65a;border:1px solid #00a65a;border-radius: 35px;}
    .radius-r div{margin-top: -21px;}
    .radius-b span{position: absolute; margin-top: 65px; margin-left:-75px;}
    .radius-b{width:800px;height:110px;margin:0 auto; margin-top:23px;}
    .progress-rm{margin-top:25px}
    .progress-r{width:170px;height:60px;float:left;margin-left: -1px}
    tr{border:2px #f4f4f4 solid}
</style>
<div class="radius-b hidden" id="progress">
  <div class="radius-r"><i class="fa fa-fw fa-check radius-g" id="radius-g-1"></i><p class="text-nowrap" style="margin-top:-29px;margin-left:-9px;">买家申请维权</p>
  </div>
  <span id="created_at"></span>
  <div class="progress-r">
    <div class="progress progress-sm active progress-rm">
        <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
          <span class="sr-only">100</span>
        </div>
    </div>
  </div>
  <div class="radius-r"><i class="fa fa-fw fa-check radius-g" id="radius-g-2"></i><p class="text-nowrap" style="margin-top:-29px;margin-left:-29px;">商家处理退款申请</p></div>
  <span id="paid_at"></span>
  <div class="progress-r">
    <div class="progress progress-sm active progress-rm">
        <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
          <span class="sr-only">100</span>
        </div>
    </div>
  </div>
  <div class="radius-r"><i class="fa fa-fw fa-check radius-g" id="radius-g-3"></i><p class="text-nowrap" id="changeText" style="margin-top:-29px;margin-left:-20px;">买家退货给商家</p></div>
  <span id="consigned_at"></span>
  <div class="progress-r">
    <div class="progress progress-sm active progress-rm">
        <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
          <span class="sr-only">100</span>
        </div>
    </div>
  </div>
  <div class="radius-r"><i class="fa fa-fw fa-check radius-g" id="radius-g-4"></i><p class="text-nowrap" id="goodChangeText" style="margin-top:-29px;">退款成功</p></div>
  <span id="signed_at"></span>
</div>
<div class="row" style="margin-bottom: 20px;">
    <div class="col-xs-6">
        <div style="padding-left: 10px;">
            <div style="height:50px; line-height: 25px;">
                <h3>售后维权</h3>
                <div>
                    <img style="height:60px;float:left;" src="" alt="缩略图"/>
                    <div style="float:left;margin-left:7px;">
                        <p id="goodName"></p><p id="goodsSku" style="margin-top:-12px;margin-left:-2px;"></p>
                    </div>
                </div>
            </div>
            <hr style="margin-top:50px;">
            退款方式：<span id="handle_type" style="height: 25px;color:#FF3300;"></span> <br>
            退款金额：<span id="money" style="height: 25px;color:#FF3300;"></span><span id="refundPostFee" style="height: 25px;"></span> <br>
            维权原因：<span id="refund_reason" style="height: 25px;"></span> <br>
            维权编号：<span id="after_sales_no" style="height: 25px;"></span>
            <hr>
            订单编号：<span id="order_no" style="height: 25px;color:#3c8dbc;"></span> <br>
            付款时间：<span id="paid_at_later" style="height: 25px;"></span> <br>
            买家：<span id="buyerName" style="height: 25px;"></span> <br>
            物流信息：<span id="postInfo" style="height: 25px;"></span> <br>
            运费：<span id="post_fee" style="height: 25px;"></span> <br>
            合计优惠：<span id="discount_fee" style="height: 25px;"></span> <br>
            实收总计：<span id="payment" style="height: 25px;color:#FF3300;"></span><span style="height: 25px;">元</span> <br>
        </div>
    </div>
    <div class="col-xs-6">
        <div>
            <div style="height:50px; line-height: 25px;" id="apply-status">
                <i class="fa fa-exclamation-circle fa-2x" aria-hidden="true" style="color:#00a65a;float:left;"></i>
                <h3 id="remind-info"></h3>
            </div>
        </div>
    </div>
    <!-- /.col -->
    <div class="col-xs-12">
         <div style="padding-left: 10px;">
            <div style="height:50px;" id="record">
                <h3>协商纪录</h3>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bs-example-modal-lg text-center" id="imgModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" >
  <div class="modal-dialog modal-lg" style="display: inline-block; width: auto;">
    <div class="modal-content">
     <img  id="imgInModalID" src="" >
    </div>
  </div>
</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">维权处理</h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning" id="refuseTitle">
                    建议您与买家协商后，在确定是否拒绝退款。如您拒绝退款后，买家可修改退款申请协议重新发起退款。
                </div>
                <div>
                    <label class="control-label" style="float:left;"><b style="color:#e01212;">&nbsp;&nbsp;</b>处理方式：</label>
                    <div>
                        <p id="temHandleType">&nbsp;</p>
                    </div>
                </div>
                <div>
                    <label class="control-label" style="float:left;"><b style="color:#e01212;">&nbsp;&nbsp;</b>退款金额：</label>
                    <div>
                        <p id="temMoney" style="color:#ff6428;">&nbsp;</p>
                    </div>
                </div>
                <div id="refundAddress">
                    <label class="control-label" style="float:left;"><b style="color:#e01212;">&nbsp;&nbsp;</b>退货地址：</label>
                    <p></p>
                </div>
                <div id="refundReason">
                    <label class="control-label required" for="text" style="float:left;"><b style="color:#e01212;">*</b>拒绝理由：</label>
                    <textarea id="refuse_reason" class="form-control" name="text" style="width:290px;" rows="3"></textarea>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" id="refuse-receipt" class="btn btn-primary" data-dismiss="modal">未收货，拒绝退款</button>
                <button type="button" id="refuse-receipt-cancel" class="btn btn-default">拒绝并关闭退款</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
@stop   
@push('js')
<script type="text/javascript" src="{{ asset('js/zclip/jquery.zclip.js') }}"></script>
<script type="text/javascript">
    var data = '',
            order = '',
            orderItem = '',
            orderItems = '',
            apply = ''; 
    $(document).ready(function () {
        $.getJSON("/orders/refund/{{$id}}",function(json) {
            data = json.data;
            order = data.order;
            orderItem = data.orderItem;
            orderItems = data.orderItems;
            var history = data.history;
            apply = data.apply;
            if(json.success) {
                $("#order_no").text(order.order_no);
                $("#paid_at_later").text(order.paid_at ? order.paid_at : '-');
                $("#buyerName").text(order.buyerName);
                $("#postInfo").text((order.post_name ? order.post_name : '') +"  "+ (order.post_code ? order.post_code : ''));
                $("#post_fee").text(order.post_fee);
                $("#discount_fee").text(order.discount_fee);
                $("#payment").text(order.payment);
                $("#handle_type").text(apply.handle_type == 1 ? '退货退款' : '仅退款');
                $("#money").text(apply.money);
                $("#refundPostFee").text("元（含运费" + apply.postFee + "元）");
                $("#refund_reason").text(apply.refund_reason);
                $("#after_sales_no").text(apply.after_sales_no);
                $("#goodName").text(orderItem.name);
                $("#goodsSku").text(orderItem.sku_properties_name);
                $("img").attr('src',orderItem.pic_thumb_path);
                if(apply.handle_type == 0) {
                    $(".radius-r:first").css('margin-left','130px');
                    $(".progress-r:last").hide();
                    $(".radius-r:last").hide();
                    if(apply.status == 20 || apply.status == 70) {
                        $("#changeText").text('退款关闭');
                    }else {
                        $("#changeText").text('退款成功');
                    }
                    $("#changeText").css('margin-left','0px');
                }else {
                    if(apply.status == 20 || apply.status == 70) {
                        $(".radius-r:first").css('margin-left','130px');
                        $(".progress-r:last").hide();
                        $(".radius-r:last").hide();
                        $("#changeText").text('退款关闭');
                    }
                }
                switch(apply.status)
                {
                    case 10 :
                        $("#radius-g-1").show();
                        $("#remind-info").text('等待商家处理退款申请');
                        if(order.status == 20) {
                            $("#apply-status").append('<p class="text-left">收到买家'+ (apply.handle_type ? '退款退货' : '仅退款') +'申请，请尽快处理。</p><button class="btn btn-primary" id="agree">同意买家退款</button><button class="btn btn-default" style="margin-left:20px;width:110px;" id="sendGoods">发货</button>');
                        }else {
                            $("#apply-status").append('<p class="text-left">收到买家'+ (apply.handle_type ? '退款退货' : '仅退款') +'申请，请尽快处理。</p><button class="btn btn-primary" id="agree">同意买家退款</button><button class="btn btn-default" style="margin-left:20px;" data-toggle="modal" data-target="#myModal" id="disagree">拒绝退款申请</button><p style="margin-top:6px;">您还可以<a href="#"  id="cancel">关闭退款</a></p>');
                        }
                        
                        break;
                    case 20 :
                        $("#radius-g-1").show();
                        $("#radius-g-2").show();
                        $("#remind-info").text('等待买家修改退款申请');
                        $("#apply-status").append('<p class="text-left">你已拒绝本次退款申请，买家修改退货申请后，需要你重新处理。</p><p style="margin-top:6px;">您还可以<a href="#" id="agree"> 同意退款给买家 </a>或者<a href="#" id="cancel"> 关闭退款 </a></p>');
                        break;
                    case 30 :
                        $("#radius-g-1").show();
                        $("#radius-g-2").show();
                        $("#remind-info").text('商家已同意退款，请退货给商家');
                        $("#apply-status").append('<p class="text-left">你已同意退款协议，请等待买家处理。</p><p style="margin-top:6px;">您还可以<a href="#" id="agree"> 已收到退货，同意退款 </a>或者<a href="#"  id="cancel"> 关闭退款 </a></p>');
                        break;
                    case 40 :
                        $("#radius-g-1").show();
                        $("#radius-g-2").show();
                        $("#radius-g-3").show();
                        $("#remind-info").text('已退货，等待商家确认收货');
                        $("#apply-status").append('<p class="text-left">你已同意退款协议，请等待买家处理。</p><p style="margin-top:6px;">买家已退货，物流公司：'+apply.post_name+'，物流单号：'+apply.post_no+'</p><button class="btn btn-primary" id="agree">确认收货并退款</button><button class="btn btn-default" data-toggle="modal" data-target="#myModal" style="margin-left:20px;" id="disagree">未收到拒绝确认</button>');
                        break;
                    case 50 :
                        $("#radius-g-1").show();
                        $("#radius-g-2").show();
                        $("#radius-g-3").show();
                        $("#goodChangeText").text('退款关闭');
                        $("#remind-info").text('商家未收到货，不同意退款申请');
                        $("#apply-status").append('<p class="text-left">你已拒绝本次退款申请，买家修改退货申请后，需要你重新处理。</p><p style="margin-top:6px;">您还可以<a href="#" id="agree"> 同意退款给买家 </a>或者<a href="#"  id="cancel"> 关闭退款 </a></p>');
                        break;
                    case 60 :
                        $("#radius-g-1").show();
                        $("#radius-g-2").show();
                        $("#radius-g-3").show();
                        if(apply.handle_type == 1) {
                            $("#radius-g-4").show();
                        }
                        $("#remind-info").text('退款成功');
                        $("#apply-status").append('<p class="text-left">申请时间：'+apply.created_at+'</p><p class="text-left">退款金额：'+apply.money+'元 </p><p class="text-left">状态：<a href="/shop/order/refund/whereabouts/'+orderItem.order_id+'">'+(apply.refundBackStatus ? '打款成功' : '打款中')+'</a></p>');
                        break;
                    case 70 :
                        $("#radius-g-1").show();
                        $("#radius-g-2").show();
                        $("#radius-g-3").show();
                        if(apply.handle_type == 1) {
                            $("#radius-g-4").show();
                        }
                        $("#remind-info").text('退款关闭');
                        $("#apply-status").append('<p class="text-left">本次退款已被商家关闭</p>');
                        break;
                }
                $("#cancel").click(function() {
                    bootbox.dialog({
                        title:'维权处理',
                        message: '关闭退款后，此售后订单关闭，买家一共最多发起3次退款申请。',
                        buttons: {
                            cancel : {
                                    label:"取消",
                                    className:"btn-default",
                                },
                            ok : {
                                    label:"确定",
                                    className:"btn-primary",
                                    callback : function() {
                                        $.get('/ajax/shop/refund/cancel/'+apply.id , function(json) {
                                            if(json.success) {
                                                bootbox.alert({
                                                    title: '<span class="text-success">成功</span>',
                                                    message:'保存成功',
                                                    callback: function () {
                                                        window.location.reload();
                                                    }
                                                });
                                            }else {
                                                bootbox.alert({
                                                    title: '<span class="text-danger">错误</span>',
                                                    message: json.error,
                                                });
                                            }
                                        });
                                    }
                                }
                            }
                    });
                });
                $("#agree").click(function() {
                    var agreeText = $("#agreeText").text();
                    if(apply.handle_type == 1) {
                        bootbox.dialog({
                            title:'维权处理',
                            message:agreeText,
                            buttons:{
                                success : {
                                    label:(apply.status == 40 || apply.status == 50 || apply.status == 30? '确认收到退货' : '同意退货，发送退货地址'),
                                    className:"btn-primary",
                                    callback:function() {
                                        $.post('/ajax/shop/refund/agree/'+apply.id,function(json) {
                                            if(json.success) {
                                                bootbox.alert({
                                                    title: '<span class="text-success">成功</span>',
                                                    message:'操作成功',
                                                    callback: function () {
                                                        window.location.reload();
                                                    }
                                                });
                                            }else {
                                                bootbox.alert({
                                                    title: '<span class="text-danger">错误</span>',
                                                    message: json.error,
                                                });
                                            }
                                        });
                                    }
                                },
                            }
                        });
                    }else {
                        bootbox.dialog({
                            title:'维权处理',
                            message:agreeText,
                            buttons:{
                                success : {
                                    label:'同意',
                                    className:"btn-primary",
                                    callback:function() {
                                        $.post('/ajax/shop/refund/agree/'+apply.id,function(json) {
                                            if(json.success) {
                                                bootbox.alert({
                                                    title: '<span class="text-success">成功</span>',
                                                    message:'操作成功',
                                                    callback: function () {
                                                        window.location.reload();
                                                    }
                                                });
                                            }else {
                                                bootbox.alert({
                                                    title: '<span class="text-danger">错误</span>',
                                                    message: json.error,
                                                });
                                            }
                                        });
                                    }
                                }
                            }
                        });
                    }
                });
                $("#temHandleType").text(apply.handle_type==1 ? '退货退款' : '仅退款');
                $("#temMoney").text('¥ ' + apply.money);
                if(apply.status != 40) {
                    $("#refuse-receipt").text('拒绝');
                    $("#refuse-receipt-cancel").hide();
                    $("#refundAddress").hide();
                    $("#refuse-receipt").click(function() {
                        var refuseReason = $("#refuse_reason").val();
                        if(!refuseReason) {
                            $("#refuse_reason").css('border','1px red solid');
                            return false;
                        }
                        $.post('/ajax/shop/refund/disagree/'+apply.id,{refuse_reason:refuseReason},function(json) {
                            if(json.success) {
                                bootbox.alert({
                                    title: '<span class="text-success">成功</span>',
                                    message:'操作成功',
                                    callback: function () {
                                        window.location.reload();
                                    }
                                });
                            }else {
                                bootbox.alert({
                                    title: '<span class="text-danger">错误</span>',
                                    message: json.error,
                                });
                            }
                        });
                    });
                }else {
                    $("#refundAddress p").text(apply.refund_address ? apply.refund_address : '-');
                    $("#refuseTitle").text('需您同意退款申请，买家才能退货给您；买家退货后您需在次确认收货，退款将自动原路退回至买家付款账户');
                    $("#refuse-receipt-cancel").click(function() {
                        bootbox.dialog({
                            title:'维权处理',
                            message: '关闭退款后，此售后订单关闭，买家一共最多发起3次退款申请。',
                            buttons: {
                                cancel : {
                                    label:"取消",
                                    className:"btn-default",
                                },
                                ok : {
                                    label:"确定",
                                    className:"btn-primary",
                                    callback : function() {
                                        $.get('/ajax/shop/refund/cancel/'+apply.id , function(json) {
                                            if(json.success) {
                                                $("#myModal").modal('hide');
                                                bootbox.alert({
                                                    title: '<span class="text-success">成功</span>',
                                                    message:'操作成功',
                                                    callback: function () {
                                                        window.location.reload();
                                                    }
                                                });
                                            }else {
                                                bootbox.alert({
                                                    title: '<span class="text-danger">错误</span>',
                                                    message: json.error,
                                                });
                                            }
                                        });
                                    }
                                }
                            }
                        });
                    });
                    $("#refuse-receipt").click(function() {
                        var refuseReason = $("#refuse_reason").val();
                        if(!refuseReason) {
                            $("#refuse_reason").css('border','1px red solid');
                            return false;
                        }
                        $.post('/ajax/shop/refund/disagree/'+apply.id,{refuse_reason:refuseReason},function(json) {
                            if(json.success) {
                                bootbox.alert({
                                    title: '<span class="text-success">成功</span>',
                                    message:'操作成功',
                                    callback: function () {
                                        window.location.reload();
                                    }
                                });
                            }else {
                                bootbox.alert({
                                    title: '<span class="text-danger">错误</span>',
                                    message: json.error,
                                });
                            }
                        });
                    });
                }
                $("#myModal").on("hide.bs.modal",function(){
                    $("#refuse_reason").css('border','');
                    $("#refuse_reason").val('');
                });
                $("#sendGoods").click(function() {
                    var sendGoodsText = $("#send").text();
                    bootbox.confirm({
                        title:'温馨提示',
                        message:'建议您先找买家沟通，买家同意后再发货',
                        buttons:{
                            cancel:{
                                label:'好，我先沟通',
                                className:'btn btn-default'
                            },
                            confirm:{
                                label:'我坚持发货',
                                className:'btn btn-primary',
                                
                            }
                        },
                        callback:stillSend
                    });
                    function stillSend(result){

                    if(result) {
                    bootbox.dialog({
                        title:'商品发货',
                        message:sendGoodsText,
                        buttons:{
                            success:{
                                label:'保存',
                                className:"btn-primary",
                                callback:function() {
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
                                    $.post('/ajax/shop/refund/consign/'+orderItem.order_id, {post_type:post_type,post_no:post_no,post_name:post_name}, function (json) {
                                        if(json.success) {
                                                bootbox.alert({
                                                title: '<span class="text-success">成功</span>',
                                                message:'保存成功',
                                                callback: function () {
                                                    window.location.reload();
                                                }
                                            });
                                        }else {
                                            bootbox.alert({
                                                title: '<span class="text-danger">错误</span>',
                                                message: json.error,
                                            });
                                        }
                                    },'json');
                                }
                            }
                        }
                    });
                    }
                    }
                });
                $("#progress").attr({'class':'show','class':'radius-b'});
                for (var i = history.length - 1; i >= 0; i--) {
                    switch(history[i].status)
                    {
                        case 10 :
                            var img = '';
                            if(history[i].refund_img.length) {
                                for (var t = history[i].refund_img.length - 1; t >= 0; t--) {
                                    img += '<img src="'+history[i].refund_img[t]+'" class="img-thumbnail" style="width:70px;" alt="图片"/>';
                                };                                
                            }
                            $("#record").append('<div style="margin-top:30px;"><p style="width:100px;float:left;margin-left:0px;">'+(history[i].operator == 1 ? '商家' : '买家')+'</p>'+
                                '<p style="margin-left:40px;">'+history[i].created_at+'</p><hr style="margin-top:0px;margin-bottom:8px;">'+
                                '<p>发起了退款申请，等待商家处理</p>'+
                                '<p>退款原因：'+(history[i].refund_reason ? history[i].refund_reason : '-')+'</p>'+
                                '<p>处理方式：'+(history[i].handle_type==1 ? '退货退款' : '仅退款')+'</p>'+
                                '<p>货物信息：'+(history[i].is_received==1 ? '未收到货' : '已收到货')+'</p>'+
                                '<p>退款金额：'+history[i].money+'</p>'+
                                '<p>退款说明：'+(history[i].explain ? history[i].explain : '-')+'</p>'+
                                '<div id="refund-big" class="col-xs-12">'+img+'</div>'+
                                '</div>');
                                $("#refund-big img").each(function(){
                                    $(this).on('click',function(index){
                                        $("#imgInModalID").attr('src',$(this).attr('src'));
                                        $("#imgModal").modal('show');
                                    });
                                });
                            break;
                        case 20 :
                            $("#record").append('<div style="margin-top:30px;"><p style="width:100px;float:left;margin-left:0px;">'+(history[i].operator == 1 ? '商家' : '买家')+'</p>'+
                                '<p style="margin-left:40px;">'+history[i].created_at+'</p><hr style="margin-top:0px;margin-bottom:8px;">'+
                                '<p>拒绝了本次退款申请，等待买家修改</p>'+
                                '<p>拒绝原因：'+(history[i].refuse_reason ? history[i].refuse_reason : '-')+'</p>'+
                                '</div>');
                            break;
                        case 30 :
                            $("#record").append('<div style="margin-top:30px;"><p style="width:100px;float:left;margin-left:0px;">'+(history[i].operator == 1 ? '商家' : '买家')+'</p>'+
                                '<p style="margin-left:40px;">'+history[i].created_at+'</p><hr style="margin-top:0px;margin-bottom:8px;">'+
                                '<p>已同意退款申请，等待买家退货</p>'+
                                '<p>退货地址：'+(apply.refund_address ? apply.refund_address : '-')+'</p>'+
                                '</div>');
                            break;
                        case 40 :
                            var img = '';
                            if(history[i].post_img.length) {
                                for (var t = history[i].post_img.length - 1; t >= 0; t--) {
                                    img += '<img src="'+history[i].post_img[t]+'" class="img-thumbnail" style="width:70px;" alt="图片"/>';
                                };                                
                            }
                            $("#record").append('<div style="margin-top:30px;"><p style="width:100px;float:left;margin-left:0px;">'+(history[i].operator == 1 ? '商家' : '买家')+'</p>'+
                                '<p style="margin-left:40px;">'+history[i].created_at+'</p><hr style="margin-top:0px;margin-bottom:8px;">'+
                                '<p>已退货，等待商家确认收货</p>'+
                                '<p>物流名称：'+(history[i].post_name ? history[i].post_name : '-')+'</p>'+
                                '<p>物流编号：'+(history[i].post_no ? history[i].post_no : '-')+'</p>'+
                                '<p>物流备注：'+(history[i].post_mark ? history[i].post_mark : '-')+'</p>'+
                                '<div id="post-big" class="col-xs-12">'+img+'</div>'+
                                '</div>');
                                $("#post-big img").each(function(){
                                    $(this).on('click',function(index){
                                        $("#imgInModalID").attr('src',$(this).attr('src'));
                                        $("#imgModal").modal('show');
                                    });
                                });
                            break;
                        case 50 :
                            $("#record").append('<div style="margin-top:30px;"><p style="width:100px;float:left;margin-left:0px;">'+(history[i].operator == 1 ? '商家' : '买家')+'</p>'+
                                '<p style="margin-left:40px;">'+history[i].created_at+'</p><hr style="margin-top:0px;margin-bottom:8px;">'+
                                '<p>未收到退货，商家拒绝确认收货</p>'+
                                '</div>');
                            break;
                        case 60 :
                            $("#record").append('<div style="margin-top:30px;"><p style="width:100px;float:left;margin-left:0px;">'+(history[i].operator == 1 ? '商家' : '买家')+'</p>'+
                                '<p style="margin-left:40px;">'+history[i].created_at+'</p><hr style="margin-top:0px;margin-bottom:8px;">'+
                                '<p>同意退款给买家，本次维权结束</p>'+
                                '<p>退款金额：'+history[i].money+'</p>'+
                                '</div>');
                            break;
                        case 70 :
                            $("#record").append('<div style="margin-top:30px;"><p style="width:100px;float:left;margin-left:0px;">'+(history[i].operator == 1 ? '商家' : '买家')+'</p>'+
                                '<p style="margin-left:40px;">'+history[i].created_at+'</p><hr style="margin-top:0px;margin-bottom:8px;">'+
                                '<p>本次维权被'+(history[i].operator == 1 ? '商家' : '买家')+'撤销</p>'+
                                '</div>');
                            break;    
                    }
                };
                $(".box").height($("#record p:last").offset().top + 70);
            }else {
                
            }
        });
    });
</script>
<script type="text/template" id="agreeText">
<div class="alert alert-warning" id="agreeTitle">
    需您同意退款申请，买家才能退货给您；买家退货后您需在次确认收货，退款将自动原路退回至买家付款账户。
</div>
<div>
    <label class="control-label" style="float:left;">处理方式：</label>
    <div>
        <p id="temHandleType1">&nbsp;</p>
    </div>
</div>
<div>
    <label class="control-label" style="float:left;">退款金额：</label>
    <div>
        <p id="temMoney1" style="color:#ff6428;">&nbsp;</p>
    </div>
</div>
<div id="agreeChange">
    <label class="control-label" style="float:left;"></label>
    <p></p>
</div>
<script type="text/javascript">
    $("#temHandleType1").text(apply.handle_type==1 ? '退货退款' : '仅退款');
    $("#temMoney1").text('¥ ' + apply.money);
    if(apply.handle_type == 1) {
        $("#agreeChange label").text('退货地址：');
        $("#agreeChange p").text(apply.refund_address ? apply.refund_address : '-');
        if(apply.status == 10) {
            $("#agreeTitle").hide();
        }
        $("#agreeChange p").show();
    }else {
        $("#agreeTitle").hide();
        $("#agreeChange p").hide();
    }
</script>
</script>
<script type="text/template" id="send">
<form class="form-horizontal" submit="return false;" id="order-form">
    <div class="box-body">
        <table class="table table-condensed">
          <thead>
            <tr>
              <th>商品</th>
              <th>数量</th>
              <th>状态</th>
            </tr>
          </thead>
          <tbody id="goodsSendTable">
            <tr style="border:0px red solid;">
              <td colspan="3" id="cantSend"><b class="text-left">以下商品无法发货</b></td>
            </tr>
          </tbody>
        </table>
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
                        <option value="">请选择物流</option>
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
var flag = 0;
for (var i = orderItems.length - 1; i >= 0; i--) {
    if(orderItems[i].refund_apply[0] && orderItems[i].refund_apply[0].status == 60) {
        $("#goodsSendTable").append('<tr><td><p class="text-center">'+orderItems[i].name + (orderItems[i].sku_properties_name ? '<br>'+orderItems[i].sku_properties_name : '') +'</p></td><td><p class="text-center">'+orderItems[i].num+'</p></td><td><p class="text-center">退款成功</p></td></tr>');
        flag = 1;
    }else {
        $("#goodsSendTable").prepend('<tr><td><p class="text-center">'+orderItems[i].name + (orderItems[i].sku_properties_name ? '<br>'+orderItems[i].sku_properties_name : '') +'</p></td><td><p class="text-center">'+orderItems[i].num+'</p></td><td><p class="text-center">'+(orderItems[i].refund_apply[0] ? '退款中' : '未发货')+'</p></td></tr>');
    }
};
if(flag == 0) {
    $("#cantSend").hide();
}
$('#detail_address').text(order.receiver_city + order.receiver_district + order.receiver_address + ',  ' + order.receiver_name + ',  ' + order.receiver_mobile);
</script>
</script>
@endpush