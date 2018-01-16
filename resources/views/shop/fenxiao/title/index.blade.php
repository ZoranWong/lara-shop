<div class="box-body" id="view-box" style="border:1px #d3d3d3 solid;min-height:0px;margin-bottom: 10px;height: 80px;">
    <div id="row" style="margin: 0 auto;text-align: center;">
        <div class="col-md-2 font_top amount">0</div>
        <div class="col-md-2 font_top commission">0</div>
        <div class="col-md-2 font_top orders">0</div>
        <div class="col-md-2 font_top member">0</div>
    </div>
    <br>
    <br>
    <div id="row" class="row_class_order" style="margin: 0 auto;text-align: center;">
        <div class="col-md-2 font_down">今日交易金额</div>
        <div class="col-md-2 font_down">今日佣金</div>
        <div class="col-md-2 font_down">今日分销订单</div>
        <div class="col-md-2 font_down">今日新增分销商</div>
    </div>
</div>

<style>
    .font_down {
        color:#d3d3d3;
        width:25%;
    }
    .font_top{
        color: #FF6600;
        font-size:20px;
        font-family: 'Arial-BoldMT', 'Arial Bold', 'Arial';
        width:25%;
    }
</style>

<script src="http://file.creya.cn/jquery-3.2.1.min.js"></script>
<script language="javascript" type="text/javascript" src="http://vip.fenxiao.zuizan100.com.cn/statics/js/artDialog/artDialog.js" charset="UTF-8"></script>
<script language="javascript" type="text/javascript" src="http://vip.fenxiao.zuizan100.com.cn/statics/js/artDialog/plugins/iframeTools.js" charset="UTF-8"></script>
<script language="javascript" type="text/javascript" src="http://vip.fenxiao.zuizan100.com.cn/statics/js/artDialog/artDialogUtils.js" charset="UTF-8"></script>

<script type="text/javascript">
    $(function() {
        $.ajax({
            type: 'POST',
            url: '/ajax/shop/order/amount/day',
            data: '',
            error: function () {
                alert('error');
            },
            success: function (msg) {
                if (msg.code == 200) {
                    var total = msg.data;
                    if (total == null) {
                        bootbox.alert({
                            title: '<span class="text-danger">ERROR!</span>',
                            message: '没有记录!',
                        });
                    }
                    $('.amount').empty();
                    $('.commission').empty();
                    $('.orders').empty();
                    $('.member').empty();
                    $('.amount').append("￥"+total.amount);
                    $('.commission').append("￥"+total.commission);
                    $('.orders').append(total.orders);
                    $('.member').append(total.member);
                } else {
                    alert('获取数据失败!');
                }
            }
        });
    });
</script>