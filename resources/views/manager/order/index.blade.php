@extends('layouts.page')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box-header with-border">
                <h3 class="box-title">订单管理</h3>
            </div>
            <div class="box-body">
                <form method="post" class="form-horizontal" id="form">
                  <div class="col-md-3">
                      <div class="input-group col-md-12">
                          <div class="input-group-addon">订单号</div>
                          <input type="text" class="form-control input" name="code" placeholder="订单号">
                      </div>
                  </div>
                  <div class="col-md-3">
                      <div class="input-group col-md-12">
                          <div class="input-group-addon">
                              <i class="fa fa-calendar"></i>
                          </div>
                          <input type="text" name="created_at_start" class="form-control pull-right datepicker" placeholder="下单时间(开始)" readonly>

                      </div>
                  </div>
                  <div class="col-md-3">
                      <div class="input-group col-md-12">
                          <div class="input-group-addon">
                              <i class="fa fa-calendar"></i>
                          </div>
                          <input type="text" name="created_at_end" class="form-control pull-right datepicker" placeholder="下单时间(结束)" readonly>

                      </div>
                  </div>
                  <div class="col-md-3">
                      <div class="input-group col-md-12">
                          <div class="input-group-addon">微信昵称</div>
                          <input type="text" class="form-control input" name="nickname" placeholder="请填写微信昵称" maxlength="60">
                      </div>
                  </div>
                  <div class="col-md-12" style="margin-top: 8px;"></div>
                  <div class="col-md-3">
                      <div class="input-group col-md-12">
                          <div class="input-group-addon">状态</div>
                          <select class="select form-control" name="status">
                              <option value="0">全部</option>
                              <option value="WAIT">待付款</option>
                              <option value="PAID">待发货</option>
                              <option value="SEND">待收货</option>
                              <option value="COMPLETED">已完成</option>
                              <option value="CLOSED">已关闭</option>
                              <option value="REFUND">退款中</option>
                          </select>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <button type="submit" class="btn btn-primary">搜索</button>
                      <button type="reset" class="btn btn-info">重置</button>
                      <button type="button" class="btn btn-primary" id="order-download">导出</button>
                  </div>
                </form>
            </div>
        </div>
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#all" data-toggle="tab" aria-expanded="true">全部</a></li>
                    <li class=""><a href="#waitPay" data-toggle="tab" aria-expanded="false">待付款</a></li>
                    <li class=""><a href="#unsendGoods" data-toggle="tab" aria-expanded="false">待发货</a></li>
                    <li class=""><a href="#sendGoods" data-toggle="tab" aria-expanded="false">已发货</a></li>
                    <li class=""><a href="#finish" data-toggle="tab" aria-expanded="false">已完成</a></li>
                    <li class=""><a href="#close" data-toggle="tab" aria-expanded="false">已关闭</a></li>
                    <li class=""><a href="#refund" data-toggle="tab" aria-expanded="false">退款中</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="all">
                        @include('manager.order.all.index')
                    </div>
                    <div class="tab-pane" id="waitPay">
                        @include('manager.order.waitPay.index')
                    </div>
                    <div class="tab-pane" id="unsendGoods">
                        @include('manager.order.unsendGoods.index')
                    </div>
                    <div class="tab-pane" id="sendGoods">
                        @include('manager.order.sendGoods.index')
                    </div>
                    <div class="tab-pane" id="finish">
                        @include('manager.order.finish.index')
                    </div>
                    <div class="tab-pane" id="close">
                        @include('manager.order.close.index')
                    </div>
                    <div class="tab-pane" id="refund">
                        @include('manager.order.refund.index')
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('js')
<script>
    $(document).ready(function () {
        var param = "";
        var condition = false;
        var totalRecord = 0;
        $('#form').validator().on('submit', function (e) {
            if(!e.isDefaultPrevented()){
                e.preventDefault();
            }
            param = $(e.target).serialize();
            condition = false;

            if(param.indexOf("status=WAIT") > 0 ){
                $('.nav-tabs-custom ul li:eq(1)').addClass('active');
                $('.nav-tabs-custom ul li:eq(1)').siblings().removeClass('active');
                $('#waitPay').addClass('active');
                $('#unsendGoods,#sendGoods,#finish,#close,#all,#refund').removeClass('active');

            } else if(param.indexOf("status=PAID") > 0 ){
                $('.nav-tabs-custom ul li:eq(2)').addClass('active');
                $('.nav-tabs-custom ul li:eq(2)').siblings().removeClass('active');
                $('#unsendGoods').addClass('active');
                $('#waitPay,#sendGoods,#finish,#close,#all,#refund').removeClass('active');

            } else if(param.indexOf("status=SEND") > 0 ){
                $('.nav-tabs-custom ul li:eq(3)').addClass('active');
                $('.nav-tabs-custom ul li:eq(3)').siblings().removeClass('active');
                $('#sendGoods').addClass('active');
                $('#waitPay,#unsendGoods,#finish,#close,#all,#refund').removeClass('active');

            } else if(param.indexOf("status=COMPLETED") > 0 ){
                $('.nav-tabs-custom ul li:eq(4)').addClass('active');
                $('.nav-tabs-custom ul li:eq(4)').siblings().removeClass('active');
                $('#finish').addClass('active');
                $('#waitPay,#unsendGoods,#sendGoods,#close,#all,#refund').removeClass('active');

            } else if(param.indexOf("status=CLOSED") > 0 ){
                $('.nav-tabs-custom ul li:eq(5)').addClass('active');
                $('.nav-tabs-custom ul li:eq(5)').siblings().removeClass('active');
                $('#close').addClass('active');
                $('#waitPay,#unsendGoods,#sendGoods,#finish,#all,#refund').removeClass('active');

            } else if(param.indexOf("status=REFUND") > 0 ){
                $('.nav-tabs-custom ul li:last').addClass('active');
                $('.nav-tabs-custom ul li:last').siblings().removeClass('active');
                $('#refund').addClass('active');
                $('#waitPay,#unsendGoods,#sendGoods,#finish,#all,#close').removeClass('active');

            } else {
                $('.nav-tabs-custom ul li:first').addClass('active');
                $('.nav-tabs-custom ul li:first').siblings().removeClass('active');
                $('#all').addClass('active');
                $('#waitPay,#unsendGoods,#sendGoods,#finish,#close,#refund').removeClass('active');

            }
            initFunction(param);
            return false;
        });
        function initFunction(paramsJSON){
            $.get('/ajax/orders/index', paramsJSON, function(json){
                var html = '';
                var data = json.data.rows;
                var pageCount = json.data.pageTotal;
                var currentPage = json.data.currentPage;
                totalRecord = json.data.totalRecord;
                for(var i=0; i<data.length; i++) {
                    if(i%2 == 0){
                        html += "<tr bgColor='#f8fbfc'>";
                    } else {
                        html += "<tr bgColor='#eeeeee'>";
                    }

                    html += "<td colspan=6><span style='float:left; margin-left:15px;'>订单号：" + data[i].code + "</span> <span style='float:right;margin-right:15px;'><a href='/orders/detail/" + data[i].id + "'>查看详情</a></span</td>";
                    html += "</tr>";
                    for(var j=0; j<data[i].orders_item.length; j++){
                        if(i%2 == 0){
                            html += "<tr bgColor='#f8fbfc'>";
                        } else {
                            html += "<tr bgColor='#eeeeee'>";
                        }
                        html += "<td style='text-align:left;'><img src='" + data[i].orders_item[j].merchandise_main_image_url + "'  style='width:80px;height:80px;border-radius: 15%;margin-left:50px;' onerror=''><span style='width:200px; height:60px; line-height:30px; position:absolute; margin-top:10px; text-align:center; font-size:13px;'>" + data[i].orders_item[j].name + '<br>' + data[i].orders_item[j].sku_properties_name + "</span>  <span style='position: absolute;margin-left: 200px;margin-top: 10px;text-align: center;width: 80px;height: 60px;padding-top: 17px;'>¥ " + data[i].orders_item[j].price/100 + "  (&nbsp;*"+ data[i].orders_item[j].num + "&nbsp;)</span></td>";
                        var refundCase = '';
                        var refundMoneyCase = '';
                        switch(data[i].orders_item[j].refundStatus)
                        {
                          case 10 :
                            refundCase = '请等待商家处理退款申请';
                            break;
                          case 20 :
                            refundCase = '商家不同意退款申请';
                            break;
                          case 30 :
                            refundCase = '商家已同意退款，请退货给商家';
                            break;
                          case 40 :
                            refundCase = '已退货，等待商家确认收货';
                            break;
                          case 50 :
                            refundCase = '商家未到到货，不同意退款申请';
                            break;
                          case 60 :
                            refundCase = '退款成功';
                            refundMoneyCase = "<a style='border:1px red solid;font-size:5px;color:red;width:60px;height:15px;' href='/shop/order/refund/whereabouts/"+data[i].id+"'>钱款去向</a>";
                            break;
                        }
                        html += "<td style='vertical-align: middle'><a href='/shop/order/refund/"+data[i].orders_item[j].id+"'>"+ refundCase +"</a><br>"+ refundMoneyCase +"</td>";
                        if(j == 0) {
                            html += "<td rowspan=" + data[i].orders_item.length + " style='vertical-align: middle'>" + data[i].nickname + '<br>' + data[i].receiver_name + '<br>' + data[i].receiver_mobile + "</td>";
                            html += "<td rowspan=" + data[i].orders_item.length + " style='vertical-align: middle'>" + data[i].created_at +"</td>";
                            switch(data[i].status){
                              case 'WAIT': var orderStatus = '待付款';break;
                              case 'PAID': var orderStatus = '待发货';break;
                              case 'SEND': var orderStatus = '待收货';break;
                              case 'COMPLETED': var orderStatus = '已完成';break;
                              case 'CANCEL': var orderStatus = '已取消';break;
                              case 'CLOSED': var orderStatus = '已关闭';break;
                            }
                            html += "<td rowspan=" + data[i].orders_item.length + " style='vertical-align: middle'>" + orderStatus + " </td>";
                            html += "<td rowspan=" + data[i].orders_item.length + " style='vertical-align: middle'> " + data[i].paymentAmount + "<br>(含运费: " + data[i].post_feeAmount + ") </td>";
                        }

                        html += "</tr>";
                    }

                }
                html += getPaginate(currentPage,pageCount);
                if(paramsJSON.indexOf("status=10") > 0 ){
                    $('#content-waitPay').html(html);

                } else if(paramsJSON.indexOf("status=20") > 0 ){
                    $('#content-unsendGoods').html(html);

                } else if(paramsJSON.indexOf("status=30") > 0 ){
                    $('#content-sendGoods').html(html);

                } else if(paramsJSON.indexOf("status=40") > 0 ){
                    $('#content-finish').html(html);

                } else if(paramsJSON.indexOf("status=50") > 0 ){
                    $('#content-close').html(html);

                } else if(paramsJSON.indexOf("status=60") > 0 ){
                    $('#content-refund').html(html);

                } else {
                    $('#content').html(html);
                }
                function getPaginate(nowPage,pageCount){
                    var pageHtml = "<tr><td colspan=5>共" + totalRecord + "条数据，分为" + pageCount + "页&nbsp;&nbsp;&nbsp;";
                    //首页显示
                    pageHtml += '<button value="1" class="pageList">首页</button>';
                    //上一页判断
                    if( nowPage > 1 ){

                        pageHtml += '<button class="pageList" value="' + (nowPage-1) + '">上一页</button>';
                        if((nowPage-2)>0){
                            pageHtml += '<button class="pageList" value="' + (nowPage-2) + '">' + (nowPage-2) + '</button>';
                        }

                        pageHtml += '<button class="pageList" value="' + (nowPage-1) + '">' + (nowPage-1) + '</button>';
                    }
                    //当前页显示
                    pageHtml += '<button value="' + nowPage + '"><span style="font-size:16px; color:red;">' + nowPage + '</span></button>';
                    //下一页判断
                    if( nowPage < pageCount ){
                        pageHtml += '<button class="pageList" value="' + (parseInt(nowPage)+1) + '">' + (parseInt(nowPage)+1) + '</button>';
                        if((parseInt(nowPage)+2) <= pageCount){
                            pageHtml += '<button class="pageList" value="' + (parseInt(nowPage)+2) + '">' + (parseInt(nowPage)+2) + '</button>';
                        }
                        pageHtml += '<button class="pageList" value="' + (parseInt(nowPage)+1) + '">下一页</button>';
                    }
                    pageHtml += '<button class="pageList" value="' + pageCount + '">末页</button>';
                    pageHtml += "</td></tr>";
                    return pageHtml;

                }
                $('.pageList').click(function(){
                    var page = 'page=' + $(this).attr('value');
                    var paramPage = '';
                    if(param && !condition){
                        paramPage = param + '&' + page;
                        condition = false;
                    } else {
                        paramPage = page;
                        condition = true;
                    }
                    initFunction(paramPage);
                });

            });

        }
        /*导出EXCEL*/
        $('#order-download').click(function(){
            var code = $("#form input[name='code']").val();
            var created_at_start = $("#form input[name='created_at_start']").val();
            var created_at_end = $("#form input[name='created_at_end']").val();
            var nickname = $("#form input[name='nickname']").val();
            var status = $('#form [name=status]').val();
            var url = "http://"+window.location.host+"/ajax/orders/index?load=1&status="+status+"&nickname="+nickname+"&created_at_start="+created_at_start+"&created_at_end="+created_at_end+"&code="+code;
            window.open(url);

            return false;
        });
    });
</script>
@stop
