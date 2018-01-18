<style>
.box{margin-bottom: 0px}
</style>
<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div>
          <table class="table table-bordered" style="text-align: center;">
              <tr>
                  <td style="width:450px; text-align: left;"><span style="margin-right: 75px;margin-left: 150px;">商品</span><span style="margin-right: 20px;margin-left: 85px;">价格(数量)</span></td>
                  <td>售后</td>
                  <td>买家</td>
                  <td>下单时间</td>
                  <td>订单状态</td>
                  <td>实付金额</td>
              </tr>
              <tbody id="content-finish"></tbody>
          </table>

      </div>
    <!-- /.box-body -->
  </div>
  <!-- /.box -->
</div>
<!-- /.col -->
</div>

@push('js')
<script>
    $(document).ready(function () {
        var param = "status=40";
        var condition = false;
        function initFunctionFinish(paramsJSON){
            $.get('/ajax/orders/index', paramsJSON, function(json){
                var html = '';
                var data = json.data.rows;
                var pageCount = json.data.pageTotal;
                var currentPage = json.data.currentPage;
                var totalRecord = json.data.totalRecord;
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
                        html += "<td style='text-align:left;'><img src='" + data[i].orders_item[j].merchandise_main_image_url + "' style='width:80px;height:80px;border-radius: 15%;margin-left:50px;' onerror=''><span style='width:215px; height:80px;  position:absolute; padding-top:5px; text-align:center; font-size:13px; overflow:hidden;'><span style='width: 200px;height: 35px;line-height: 17px;overflow: hidden;position: absolute;left: 15px;cursor:pointer'  title=" + data[i].orders_item[j].name  + ">" + data[i].orders_item[j].name + '</span><span style="height:30px;overflow:hidden;position: absolute;top: 40px;line-height:  15px;left: 20px;right: 7px; cursor:pointer" title=' + data[i].orders_item[j].sku_properties_name + '>' + data[i].orders_item[j].sku_properties_name + "</span></span>  <span style='position: absolute;margin-left: 225px;margin-top: 10px;text-align: center;width: 80px;height: 60px;padding-top: 17px;'>¥ " + data[i].orders_item[j].price/100 + "  (&nbsp;*"+ data[i].orders_item[j].num + "&nbsp;)</span></td>";
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
                $('#content-finish').html(html);
                function getPaginate(nowPage,pageCount){
                    var pageHtml = "<tr><td colspan=5>共" + totalRecord + "条数据，分为" + pageCount + "页&nbsp;&nbsp;&nbsp;";
                    //首页显示
                    pageHtml += '<button value="1" class="pageList_finish">首页</button>';
                    //上一页判断
                    if( nowPage > 1 ){

                        pageHtml += '<button class="pageList_finish" value="' + (nowPage-1) + '">上一页</button>';
                        if((nowPage-2)>0){
                            pageHtml += '<button class="pageList_finish" value="' + (nowPage-2) + '">' + (nowPage-2) + '</button>';
                        }

                        pageHtml += '<button class="pageList_finish" value="' + (nowPage-1) + '">' + (nowPage-1) + '</button>';
                    }
                    //当前页显示
                    pageHtml += '<button value="' + nowPage + '"><span style="font-size:16px; color:red;">' + nowPage + '</span></button>';
                    //下一页判断
                    if( nowPage < pageCount ){
                        pageHtml += '<button class="pageList_finish" value="' + (parseInt(nowPage)+1) + '">' + (parseInt(nowPage)+1) + '</button>';
                        if((parseInt(nowPage)+2) <= pageCount){
                            pageHtml += '<button class="pageList_finish" value="' + (parseInt(nowPage)+2) + '">' + (parseInt(nowPage)+2) + '</button>';
                        }
                        pageHtml += '<button class="pageList_finish" value="' + (parseInt(nowPage)+1) + '">下一页</button>';
                    }
                    pageHtml += '<button class="pageList_finish" value="' + pageCount + '">末页</button>';
                    pageHtml += "</td></tr>";
                    return pageHtml;

                }
                $('.pageList_finish').click(function(){
                    var page = 'page=' + $(this).attr('value');
                    var paramPage = '';
                    if(param && !condition){
                        paramPage = param + '&' + page;
                        condition = false;
                    } else {
                        paramPage = page;
                        condition = true;
                    }
                    initFunctionFinish(paramPage);
                });
            });
        }
        initFunctionFinish(param);

         // 日期控件
        $('.datepicker').datetimepicker({
            autoclose: true,
            language: 'zh-CN',
            format: 'yyyy-mm-dd'
        });
    })
</script>
@endpush
