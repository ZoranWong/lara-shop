@extends('layouts.box_base')
@section('box-title')
订单详情
<div class="btn-group" style="position:absolute;right:20px;top:5px">
<a href="/shop/order" class="btn btn-sm btn-primary"><i class="fa fa-list"></i>&nbsp;返回</a>
</div>
@stop
@section('box-body')
<style>
.table tr,.table td,.table th{text-align:center;}
.deliver{width:130px;height:40px;float:right;display:none}
.box-success{width:90%;margin:0 auto}
.radius-b{width:800px;height:90px;margin:0 auto}
.progress-rm{margin-top:25px}
.pull-center-s{margin-left: 100px;width:100px}
.radius-g{position: absolute;font-size: 40px;top:10px;left:5px;color:#fff;z-index: 9;display:none}
.radius-r{position: relative;width:60px;height:60px;float:left;background:#00a65a;border:1px solid #00a65a;border-radius: 35px}
.radius-r div{margin-top: 62px}
.box-header{height:60px}
.box-header .box-t{position: absolute;left: -40px;top:10px;height:41px !important;width:100px !important;
  color:#fff;background:#00a65a;line-height: 40px;font-size: 18px;text-align: center;float:left}
.box-header .box-fa{position: absolute;left: 47px;top:8px;height:40px !important;width:40px !important;float:left;text-align: left;}
.box-header .box-fa i{color:#00a65a;font-size: 46px;}
.progress-r{width:170px;height:60px;float:left;margin-left: -1px}
</style>
<div class="radius-b">
  <div class="radius-r"><i class="fa fa-fw fa-check radius-g" id="radius-g-1"></i><div>提交订单</div></div>
  <div class="progress-r">
    <div class="progress progress-sm active progress-rm">
        <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
          <span class="sr-only">100</span>
        </div>
    </div>
  </div>
  <div class="radius-r"><i class="fa fa-fw fa-check radius-g" id="radius-g-2"></i><div>支付订单</div></div>
  <div class="progress-r">
    <div class="progress progress-sm active progress-rm">
        <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
          <span class="sr-only">100</span>
        </div>
    </div>
  </div>
  <div class="radius-r"><i class="fa fa-fw fa-check radius-g" id="radius-g-3"></i><div>平台发货</div></div>
  <div class="progress-r">
    <div class="progress progress-sm active progress-rm">
        <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
          <span class="sr-only">100</span>
        </div>
    </div>
  </div>
  <div class="radius-r"><i class="fa fa-fw fa-check radius-g" id="radius-g-4"></i><div>确认收货</div></div>
</div>
<div class="box box-success">
  <div class="box-header with-border">
      <h3 class="box-title" id="order_title"></h3>
      <span class="deliver">
        <button type="button" class="btn btn-block btn-primary btn-sm right" style="width:80px" id="now-deliver">去发货</button>
      <span>
      </div>
      <div class="box-body">
        <div class="box">
          <div class="box-header">
            <div class="box-t">基本信息</div>
            <div class="box-fa"><i class="fa fa-fw fa-play"></i></div>
          </div>
          <div class="box-body no-padding">
            <table class="table table-bordered">
              <tr>
                <th>订单编号</th>
                <th>下单时间</th>
                <th>用户账号</th>
                <th>支付方式</th>
                <th>配送方式</th>
                <th>物流单号</th>
                <th>收货时间</th>
              </tr>
              <tr>
                <td id="order_no"></td>
                <td id="created_at"></td>
                <td id="nickname"></td>
                <td id="paid_type"></td>
                <td id="post_type"></td>
                <td id="post_no"></td>
                <td id="signed_at"></td>
              </tr>
            </table>
          </div>
        </div>

        <div class="box">
          <div class="box-header">
            <div class="box-t">收货人信息</div>
            <div class="box-fa"><i class="fa fa-fw fa-play"></i></div>
          </div>
          <div class="box-body no-padding">
            <table class="table table-bordered">
              <tr>
                <th>收货人</th>
                <th>手机号码</th>
                <th>邮政编码</th>
                <th>收货地址</th>
              </tr>
              <tr>
                <td id="receiver_name"></td>
                <td id="receiver_mobile"></td>
                <td id="post_code"></td>
                <td id="address"></td>
              </tr>
            </table>
          </div>
        </div>

        <div class="box">
          <div class="box-header">
            <div class="box-t">商品信息</div>
            <div class="box-fa"><i class="fa fa-fw fa-play"></i></div>
          </div>
          <div class="box-body no-padding">
            <table class="table table-bordered" id="goods_info">
              <tr>
                <th>商品图片</th>
                <th>商品名称</th>
                <th>价格/货号</th>
                <th>属性</th>
                <th>数量</th>
                <th>库存</th>
                <th>小计</th>
              </tr>
            </table>
          </div>
        </div>

        <div class="box">
          <div class="box-header">
            <div class="box-t">物流信息</div>
            <div class="box-fa"><i class="fa fa-fw fa-play"></i></div>
          </div>
          <div class="box-body no-padding">
            <table class="table table-bordered" id="goods_info">
              <tr>
                <th>物流公司</th>
                <th>物流单号</th>
                <th>收货时间</th>
              </tr>
              <tr>
                <td id="post_name"></td>
                <td id="post_no_t"></td>
                <td id="signed_at_t"></td>
              </tr>
            </table>
          </div>
        </div>

        <div class="box">
          <div class="box-header">
            <div class="box-t">费用信息</div>
            <div class="box-fa"><i class="fa fa-fw fa-play"></i></div>
          </div>
          <div class="box-body no-padding">
            <table class="table table-bordered" id="goods_info">
              <tr>
                <th>商品合计</th>
                <th>运费</th>
                <th>订单总金额</th>
                <th>应付款总金额</th>
              </tr>
              <tr>
                <td id="good_fee"></td>
                <td id="post_fee"></td>
                <td id="order_fee"></td>
                <td id="payment"></td>
              </tr>
            </table>
          </div>
        </div>
      </div>
    </div>
    @stop

    @section('js')
    <script>
    $(document).ready(function () {
      var $deliver = $(".deliver");
      var isDeliver = false;
      var id = {{ $id }}
      var orderNo = '';
      var postType = {10:'物流发货',20:'无需物流'}
      $.getJSON('/ajax/shop/order/detail/' + id, function (json) {
        var data = json.data
        var status = {10:'未支付',20:'待发货',30:'待收货',40:'已完成',50:'已取消',}
        var paidType = {wxpay: '微信', alipay: '支付宝',unionpay:'银联',other:'其他'}
        orderNo = data.order_no;
        data.order_title = '<strong>当前订单状况：'+status[data.status]+'</strong>';
        data.order_fee = '￥' + (data.good_fee + data.post_fee)/100;
        data.good_fee = '￥' + data.good_fee/100;
        data.post_fee = data.post_fee ? '￥' + data.post_fee/100 : 0;
        data.payment = '￥' + data.payment/100;
        if(typeof(data.weapp_user.nickname) != 'undefined'){
            data.nickname = data.weapp_user.nickname;
        }
        //显示导向图步骤
        $('#radius-g-1').show();
        if(data.paid_at > 0 || data.status == 20){
          $('#radius-g-1,#radius-g-2').show();
        }
        if(data.consigned_at > 0 || data.status == 30){
          $('#radius-g-1,#radius-g-2,#radius-g-3').show();
        }
        if(data.signed_at > 0 || data.status == 40){
          $('#radius-g-1,#radius-g-2,#radius-g-3,#radius-g-4').show();
        }

        //支付方式
        if(data.paid_type != 20 && data.paid_type != 50){
          data.paid_type = paidType[data.paid_type];
        }else{
          data.paid_type = '未支付';
        }
        if(data.status == 20){
          isDeliver = true;
          $deliver.show();
        }
        data.signed_at = (data.signed_at > 0) ? new Date(parseInt(data.signed_at) * 1000).toLocaleString().replace(/:\d{1,2}$/,' ') : '未收货';
        //发货方式
        if(data.post_type > 0){
          data.post_type = postType[data.post_type];
        }else{
          data.post_type = '未发货';
        }
        data.address = data.receiver_city + data.receiver_district + data.receiver_address;
        if(data.orders_item.length > 0){
          var item = data.orders_item;
          var otStr = '';
          var money = 0;
          for(var i in item){
            //if(item[i].good_status == 1 || data.status != 10){
              money += item[i].total_fee;
              item[i].goods_no = (item[i].goods_no == null) ? '' : item[i].goods_no;
              otStr += '<tr><td><img src="'+ item[i].pic_thumb_path + '" style="height:50px;width:80px"></td>';
              otStr += '<td>' + item[i].name + '</td>';
              otStr += '<td>' + '￥' + item[i].price/100 + '/' + item[i].goods_no + '</td>';
              otStr += '<td>' + item[i].sku_properties_name + '</td>';
              otStr += '<td>' + item[i].num + '</td>';
              if(typeof(item[i].goods) != 'undefined' && item[i].goods != null){
                otStr += '<td>' + item[i].goods.stock_num + '</td>';
              }else{
                otStr += '<td>0</td>';
              }
              otStr += '<td>' + '￥' + item[i].total_fee/100 + '</td></tr>';
            //}
          }
          otStr += '<tr><td></td><td></td><td></td><td></td><td></td><td></td>';
          otStr += '<td>合计：￥'+ money/100 +'</td></tr>';
          $('#goods_info').append(otStr);
        }
        $("#signed_at_t").html(data.signed_at);
        $("#post_no_t").html(data.post_no);
        for(name in data){
          $('#' + name).html(data[name]);
        }
      });
      $("#now-deliver").on('click',function(){
        if(!isDeliver)return;
        var deliverHtml = '<form class="form-horizontal" submit="return false;" id="order-form"><div class="box-body"><div class="form-group"><label for="d-post-type" class="col-sm-2 control-label">发货方式:</label>';
        deliverHtml += '<div class="col-sm-6"><span class="form-control" style="border:none"><input type="radio" class="post-chose" name="post_type" value="10" checked>物流发货&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" class="post-chose" name="post_type" value="20">无需物流</span></div></div></div>';
        deliverHtml += '<div class="form-group" id="post-form"><label for="d-post-no" class="col-sm-2 control-label">物流公司:</label>';
        deliverHtml += '<div class="col-sm-10"><div style="float:left;width:130px"><select class="form-control" id="post-name"><option value="">请选择物流</option>';
        deliverHtml += '<option value="顺丰快递">顺丰快递</option>';
        deliverHtml += '<option value="申通快递">申通快递</option>';
        deliverHtml += '<option value="圆通快递">圆通快递</option>';
        deliverHtml += '<option value="韵达快递">韵达快递</option>';
        deliverHtml += '<option value="天天快递">天天快递</option>';
        deliverHtml += '<option value="EMS">EMS</option>';
        deliverHtml += '<option value="中国邮政">中国邮政</option>';
        deliverHtml += '<option value="中通快递">中通快递</option>';
        deliverHtml += '<option value="国通快递">国通快递</option>';
        deliverHtml += '<option value="其他">其他</option>';
        deliverHtml += '</select></div><div style="float:left;width:300px;margin-left:5px"><span style="float:left;line-height:34px"><strong>快递单号：</strong></span><input type="text" style="float:left;width:180px" class="form-control" id="d-post-no" placeholder="请输入单号"></div>';
        deliverHtml += '</div></div></div></div></form>';
        bootbox.dialog({
          title: '当前发货订单号：' + orderNo,
          message: deliverHtml,
          buttons:{
            success:{
              label : "确定",
              className:"btn btn-primary pull-left pull-center-s sub-order",
              callback:function(){
                var post_type = $("input:radio[name='post_type']:checked").val();
                var post_name = '';
                var post_no = '';
                if(post_type == 10){
                  var post_no = $.trim($("#d-post-no").val());
                  var post_name = $("#post-name").val();
                  var alertLog = '';
                  if(post_name == ''){
                    alertLog = '物流公司不能为空';
                  }
                  if(post_no.length == 0){
                    alertLog = '物流单号不能为空';
                  }
                  if(post_no.length > 30){
                    alertLog = '物流单号长度过长';
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
                $.post('/ajax/shop/order/consign/'+id, {post_type:post_type,post_no:post_no,post_name:post_name}, function (json) {
                  if (json.code == 200) {
                    isDeliver = false;
                    $deliver.hide();
                    $('#order_title').html('当前订单状态：已发货');
                    $('#post_type').html(postType[post_type]);
                    $('#post_no').html(post_no);
                    $('#signed_at').html('未收货');
                    $('#radius-g-3').show();
                    $('#post_name').html(post_name);
                    $('#post_no_t').html(post_no);
                    $.notify({
                      message: "订单发货成功"
                    },{
                      type: 'success',
                      placement: {
                        from: "top",
                        align: "center"
                      },
                    })
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
                }, 'json')
              }
            }
          }
        });
      })

      $("body").bind('click','.post-chose',function(e){
        if(e.target.className != 'post-chose')return;
        var postType = $("input:radio[name='post_type']:checked").val();
        if(postType == 10){
          $("#post-form").show();
        }
        if(postType == 20){
          $("#post-form").hide();
        }
      })
    })
    </script>
    @stop
