@extends('my.box_base')
@section('box-body')
<style type="text/css">
th{text-align: center;}
td{text-align: center;}
</style>
<div class="table-responsive">
  <table class="table">
    <thead>
      <tr class="active">
        <th colspan="5"><p style="float:left;" id="refundMoney"></p><p style="float:right;" id="orderNo"></p></th>
      </tr>
      <tr class="active">
        <th>退款编号</th>
        <th>退款流水号</th>
        <th>申请时间</th>
        <th>金额（元）</th>
        <th>状态</th>
      </tr>
    </thead>
    <tbody id="list">
    </tbody>
  </table>
</div>
@stop   
@push('js')
<script type="text/javascript">
var refundingAt = '';
var arriveAt = '';
var why = '';
$(document).ready(function () {
	
	$.getJSON('/ajax/shop/refund/whereabout/'+{{$id}},function(json) {
		if(json.success) {
			var data = json.data;
			for (var i = data.item.length - 1; i >= 0; i--) {
				$("#list").append('<tr><td>'+(data.item[i].refund_back_id ? data.item[i].refund_back_id : '-')+'</td><td>'+(data.item[i].refund_id ? data.item[i].refund_id : '-')+'</td><td>'+data.item[i].apply_at+'</td><td>'+data.item[i].total_fee+'</td><td><a data-refunding_at="'+data.item[i].refunding_at+'" data-arrive_at="'+data.item[i].arrive_at+'" data-id="'+data.item[i].order_item_id+'" data-why="'+data.item[i].return_msg+'" href="javascript:void(0);">'+data.item[i].refund_status+'</a></td></tr>');
			};
			$("#refundMoney").text('退款总额：'+data.total_money+'元');
			$("#orderNo").append('订单：<a href="/shop/order/detail2/'+{{$id}}+'">'+data.order_no+'</a>');
			$("#list a").click(function() {
				if($(this).text() == '商家退款中' || $(this).text() == '确认到账') {
					var speed = $("#speed").text();
					refundingAt = $(this).data('refunding_at');
					arriveAt = $(this).data('arrive_at');
					bootbox.dialog({
						title:'了解退款进度',
						message:speed,
						buttons:{
							cancel:{
								label:'取消',
								className:'btn btn-default'
							}
						}
					});
				}else if($(this).text() == '转入代发') {
					bootbox.dialog({
						title:'了解退款进度',
						message:'<span>退款到银行发现用户的卡作废或者冻结了，导致原路退款银行卡失败，资金回流到商户的现金帐号，需要商户人工干预，通过线下或者财付通转账的方式进行退款。</span>',
						buttons:{
							cancel:{
								label:'取消',
								className:'btn btn-default'
							}
						}
					});
				}else {
					var itemId = $(this).data('id');
					why = $(this).data('why');
					var replay = $("#replay").text();
					bootbox.confirm({
						title:'了解退款进度',
						message:replay,
						buttons:{
							confirm:{
								label:"确定",
                            	className:"btn btn-primary"
							},
							cancel: {
	                            label:'取消',
	                            className:"btn btn-default"
	                        }
						},
						callback: function(result){
							if(result) {
								$.get('/ajax/shop/refund/refund/replay/'+itemId,function(json) {
									if(json.success) {
		                                    bootbox.alert({
		                                    title: '<span class="text-success">成功</span>',
		                                    message:'退款中...',
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
								})
							}
						}
					});
				}
			});
		}
	});
});
</script>
<script type="text/template" id="speed">
<div style="margin-top:30px;margin-botom:40px;">
<i class="fa fa-circle fa-2x" aria-hidden="true" style="margin-top:-10px;margin-left:40px;position: absolute;color:#00a65a;"></i>
<div class="progress progress-striped active" style="height:10px;width:80%;margin-left:55px;">
    <div id="now" class="progress-bar progress-bar-success" role="progressbar"
         aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"
         style="width: 50%;height:10px;">
        <span class="sr-only">40% 完成</span>
    </div>
</div>
<i class="fa fa-circle fa-3x" aria-hidden="true" style="margin-top:-45px;color:white;margin-left:82%;position: absolute;"></i>
<i class="fa fa-circle-thin fa-3x" aria-hidden="true" style="margin-top:-45px;color:#00a65a;margin-left:82%;position: absolute;"></i>
<i id="check" class="fa fa-check fa-2x" aria-hidden="true" style="margin-top:-39px;color:#00a65a;margin-left:82.5%;position: absolute;display:none;"></i>
<p style="float:left;margin-left:24px;">商家退款</p><p style="float:right;margin-right:30px;">确认到账</p>
<p id="refunding_at" style="margin-left:0px;position: absolute;margin-top:20px;"></p>
<p id="arrive_at" style="margin-left:75%;position: absolute;margin-top:20px;"></p>
<p>&nbsp;</p>
</div>
<script type="text/javascript">
if(refundingAt) {
	$("#refunding_at").text(refundingAt);
}
if(arriveAt) {
	$("#arrive_at").text(arriveAt);
	$("#check").show();
	$("#now").css('width','100%');
}
</script>
</script>
<script type="text/template" id="replay">
<p>状态：退款异常</p><p id="why"></p><p>是否重新打款？</p>
<script type="text/javascript">
$("#why").text('原因：'+why);
</script>
</script>
@endpush