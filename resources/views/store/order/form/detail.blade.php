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
<div class="radius-b">
    <div class="radius-r">
        <i class="fa fa-fw fa-check radius-g" id="radius-g-1" style="{{$order['step'] >= 1? "display:inline;" : ""}}"></i>
        <div>买家下单</div>
    </div>
    <span id="created_at">{{$order['step'] >= 1 ? $order['created_at'] : ''}}</span>
    <div class="progress-r">
        <div class="progress progress-sm active progress-rm">
            <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                <span class="sr-only">100</span>
            </div>
        </div>
    </div>
    <div class="radius-r"><i class="fa fa-fw fa-check radius-g" id="radius-g-2" style="{{$order['step'] >= 2 ? "display:inline;" : ""}}"></i><div>买家付款</div></div>
    <span id="paid_at">{{$order['step'] >= 2 ? date('Y-m-d h:i:s', $order['paid_at']) : ''}}</span>
    <div class="progress-r">
        <div class="progress progress-sm active progress-rm">
            <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                <span class="sr-only">100</span>
            </div>
        </div>
    </div>
    <div class="radius-r"><i class="fa fa-fw fa-check radius-g" id="radius-g-3" style="{{$order['step'] >= 3 ? "display:inline;" : ""}}"></i><div>商家发货</div></div>
    <span id="consigned_at">{{$order['step'] >= 3  ? date('Y-m-d h:i:s', $order['send_at']) : ''}}</span>
    <div class="progress-r">
        <div class="progress progress-sm active progress-rm">
            <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                <span class="sr-only">100</span>
            </div>
        </div>
    </div>
    <div class="radius-r"><i class="fa fa-fw fa-check radius-g" id="radius-g-4" style="{{$order['step'] >= 4 ? "display:inline;" : ""}}"></i><div>确认收货</div></div>
    <span id="signed_at">{{$order['step'] >= 4 ? date('Y-m-d h:i:s', $order['completed_at']) : ''}}</span>
</div>
<div class="row" style="margin-bottom: 20px;">
    <div class="col-xs-6">
        <div style="padding-left: 10px;">
            <div style="height:50px; line-height: 25px;">
                <h3>订单信息</h3>
                订单号：<span id="order_no">{{$order['code']}}</span>
                买家：<span id="buyer">{{$order['user']['nickname']}}</span>
            </div>
            <hr>
            配送方式：<span id="post_type" style="height: 25px;">{{$order['post_type']}}</span> <br>
            收货地址：
            <div id="targetData">
                <span id="receiver_address" style="height: 25px;">{{$order['receiver_address']}}</span>,
                <span id="receiver_name">{{$order['receiver_name']}}</span>,
                <span id="receiver_mobile">{{$order['receiver_mobile']}}</span>
            </div>
            <span id="copy_word" style="font-size:12px; color:#ab9a9a;">［复制］</span>
        </div>


    </div>
    <div class="col-xs-6">
        <div style="line-height: 15px;">
            <h3>订单状态：<span id="orderStatus">{{$order['status_str']}}</span></h3>
            <p id="refundMoney"></p>
            <button class="btn btn-warning" id="close" style="display: none;">关闭订单</button>
            <button
                    type="button" class="btn btn-block btn-primary btn-sm right"
                    style="{{$order['step'] == 2 ? "width: 80px;" : "width: 80px; display: none;"}}"
                    data-toggle="modal" data-target="#send-merchandise-modal">去发货</button>
        </div>
        <hr style="margin-top:7px;">
        <font color="orange">提醒：</font><span id="tip" style="height: 30px; line-height: 30px;">{{$order['tip']}}</span>
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->
<div class="box-body">
    <table class="table" id="table">
        <thead>
            <tr  style="background:gainsboro;">
                <th style="width:450px; text-align: left;" colspan='2'><span style="margin-right: 75px;margin-left: 150px;">商品</span><span style="margin-right: 20px;margin-left: 102px;">价格</span></th>
                <th style="width:10%;">数量</th>
                <th style="width:19%;">小计（元）</th>
                <th style="width:19%;">状态</th>
            </tr>
            <tr>
                <td colspan="5" id="post_name" style="text-align: left; padding-left: 50px">{{$order['post']}}</td>
            </tr>
        </thead>
        <tbody>
            @foreach($order->orderItems as $item)
                <tr style=" font-size:12px;">
                    <td colspan="2" style="text-align:left;">
                        <img
                                src="{{$item['merchandise_main_image_url']}}"
                                style="width:80px;height:80px;border-radius: 15%;margin-left:50px;"
                                onerror="">
                        <span style="width:215px; height:80px;position:absolute; padding-top:5px; text-align:center; font-size:13px;overflow: hidden;">
                            <span style="width:200px;height:35px;line-height: 17px;overflow: hidden;position: absolute;left: 15px;cursor:pointer;" title="{{$item['name']}}">
                                {{$item['name']}}
                            </span>
                            <span style="height:30px;overflow:hidden;position:absolute;top: 40px;line-height:  15px;left: 20px;right: 7px; cursor:pointer;"
                                  title="{{$item['sku_properties_name']}}">{{$item['sku_properties_name']}}
                            </span>
                        </span>
                        <span style="position: absolute;margin-left: 206px;margin-top: 10px;text-align: center;width: 80px;height: 60px;padding-top: 17px;">
                            {{$item['price']}}
                        </span>
                    </td>
                    <td style="text-align:center;padding-top:35px;">{{$item['num']}}</td>
                    <td style="text-align:center;padding-top:35px;">{{$item['total_fee']}}</td>
                    <td style="text-align:center;padding-top:35px;" data-change='+readyChange+' class="signed_at">
                        @if($item['refund'])
                            @switch($item['refund']['status'])
                                @case('REFUNDING')
                                    <a href='/shop/order/refund/{{$item['id']}}'>退款中</a>
                                    @break;
                                @case('REFUNDED')
                                    <a href='/shop/order/refund/{{$item['id']}}'>退款成功</a>
                                    @break;
                            @endswitch
                        @else
                            <span>{{$item['status_str']}}</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<!-- Modal -->
<div class="modal fade" id="send-merchandise-modal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <span class="text-danger">商品发货</span>
            </div>
            <div class="modal-body">
                <!-- /*查看某商品独立佣金详情 */ -->
                <form class="form-horizontal" submit="return false;" id="order-form">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="d-post-type" class="col-sm-2 control-label">订单编号:</label>
                            <div class="col-sm-6" id="order_number">
                                {{$order['code']}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="d-post-type" class="col-sm-2 control-label">收货地址:</label>
                            <div class="col-sm-10" id="detail_address">
                                {{$order['receiver_address']}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="d-post-type" class="col-sm-2 control-label">发货方式:</label>
                            <div class="col-sm-8">
                        <span class="form-control" style="border:none">
                        <input type="radio" class="post-chose"    name='post'  value="10" checked>物流发货&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" class="post-chose" name='post' value="20">无需物流
                        </span>
                            </div>
                        </div>
                        <div class="form-group" id="post-form">
                            <label for="d-post-no" class="col-sm-2 control-label">物流公司:</label>
                            <div class="col-sm-10">
                                <div style="float:left;width:130px">
                                    <select class="form-control" id="post-name" name = "post_type">
                                        @foreach(\App\Models\Order::POST_TYPE as $key => $value)
                                            <option value="{{$key}}" {{$key == 'EMS' ? 'selected' : ''}}>{{$value}}</option>
                                        @endforeach
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
            </div>
            <div class="modal-footer">
                <button type="button" id = "send-merchandise-btn" class="btn btn-default" >保存</button>
            </div>
        </div>

    </div>
</div>
<script type="text/javascript" src="{{ asset('js/zclip/jquery.zclip.js') }}"></script>
<script type="text/javascript">
    var order = {!!$order!!};
    window.pageInit = function () {
        console.log('page init', order);
        var post = {};
        post['post_type'] = 'EMS';
        $('#close').click(function(){

        });
        $('#merchandise').click(function(){

        });
        $('#send-merchandise-btn').unbind('click').bind('click', function(e){
            if(post['post_type'] == undefined || post['post_type'] == null){
                bootbox.alert({
                    title: '<span class="text-danger">提示</span>',
                    message: "请选择快递公司填写快递单号",
                });
                return;
            }
            if(post['post_type'] != 'NONE' )
                post['post_type'] = $('#post-name').val();
            post['post_no'] = $('#d-post-no').val();
            if(post['post_type'] == 'NONE' || (post['post_type'] != undefined && !!post['post_type'] && post['post_no'] != undefined)){
                $.ajax({
                    url:'/ajax/order/'+order['id']+'/send/merchandise',
                    type: "PUT",
                    contentType: "application/json",
                    dataType: "json",
                    data: JSON.stringify(post)
                }).done(function (res) {
                    if(res.hasError){
                        bootbox.alert({
                            title: '<span class="text-danger">提示</span>',
                            message: res.error,
                        });
                        return;
                    }else{
                        bootbox.alert({
                            title: '<span class="text-danger">提示</span>',
                            message: "请选择快递公司填写快递单号",
                        });
                        $.pjax.reload('#pjax-container');
                        $('#send-merchandise-modal').modal('hide');
                        return;
                    }
                }).fail(function(error){

                });

            }else{
                bootbox.alert({
                    title: '<span class="text-danger">提示</span>',
                    message: "请选择快递公司填写快递单号",
                });
            }
        });

        $(".post-chose").unbind('click').bind('click', function(e){
            if(e.target.className != 'post-chose')return;
            var postType = $("input:radio[name='post']:checked").val();
            if(postType == 10){
                $("#post-form").show();
                post['post_type'] = null;
            }
            if(postType == 20){
                $("#post-form").hide();
                post['post_type'] = 'NONE';
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
    }
</script>