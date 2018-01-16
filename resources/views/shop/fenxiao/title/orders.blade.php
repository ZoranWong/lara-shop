<div class="row col-sm-12">
    <div class="row col-lg-6" style="width:1000px;">
        <section class="panel panel-default">
            <div class="panel-body" style="width:800px;">
                <div id="main" style="width:900px;height: 300px"></div>
            </div>
        </section>
    </div>
    {{--<div class="row col-lg-6" style="width:1000px;">--}}
        {{--<section class="panel panel-default">--}}
            {{--<div class="panel-body" style="width:800px;">--}}
                {{--<div id="main2" style="width:900px;height: 300px"></div>--}}
            {{--</div>--}}
        {{--</section>--}}
    {{--</div>--}}
</div>
<script src="http://file.creya.cn/echarts.common.min.js"></script>

<script type="text/javascript">
    $(function() {
        $.ajax({
            type: 'POST',
            url: '/ajax/shop/order/chart/day',
            data: '',
            error: function () {
                bootbox.alert({
                    title: '<span class="text-danger">ERROR!</span>',
                    message: '请求失败!',
                });
            },
            success: function (msg) {
                if (msg.code == 200) {
                    var total = msg.data;
//                    flash_back(total.day);
                    var day=total.day;
                    var amount = total.amount;
                    var commission = total.commission;
                    var member = total.member;
                    var orders = total.orders;
                    day.reverse();
                    amount.reverse();
                    commission.reverse();
                    member.reverse();
                    orders.reverse();

                    if (total == null) {
                        bootbox.alert({
                            title: '<span class="text-danger">ERROR!</span>',
                            message: '没有记录!',
                        });
                    }
                    var myChart = echarts.init(document.getElementById('main'));
//                    var myChart1 = echarts.init(document.getElementById('main2'));

                    myChart.setOption({
                        title: {
                            text: '订单、交易额'
                        },
                        tooltip: {
                            trigger: 'axis'
                        },
                        legend: {
                            data:['订单量','交易额']
                        },
                        grid: {
                            left: '3%',
                            right: '4%',
                            bottom: '3%',
                            containLabel: true
                        },
                        toolbox: {
                            show:true,
                            feature: {
                                magicType:{show:true,type:['line','bar']},
                                saveAsImage: {
                                    show:true,
                                    excludeComponents:['toolbox'],
                                    pixelRatio:2
                                }
                            }
                        },
                        xAxis: {
                            type: 'category',
                            boundaryGap: false,
                            data:day
                        },
                        yAxis: {
                            type: 'value'
                        },
                        series: [
                            {
                                name:'订单量',
                                type:'line',
                                data:total.orders
                            },
                            {
                                name:'交易额',
                                type:'line',
                                data:total.amount
                            }
                        ]
                    });
//                    myChart1.setOption({
//                        title: {
//                            text: '交易额、佣金'
//                        },
//                        tooltip: {
//                            trigger: 'axis'
//                        },
//                        legend: {
//                            data:['交易额','佣金']
//                        },
//                        grid: {
//                            left: '3%',
//                            right: '4%',
//                            bottom: '3%',
//                            containLabel: true
//                        },
//                        toolbox: {
//                            feature: {
//                                magicType:{show:true,type:['line','bar']},
//                                saveAsImage: {show:false}
//                            }
//                        },
//                        xAxis: {
//                            type: 'category',
//                            boundaryGap: false,
//                            data:total.day
//                        },
//                        yAxis: {
//                            type: 'value'
//                        },
//                        series: [
//                            {
//                                name:'交易额',
//                                type:'line',
//                                data:total.amount
//                            },
//                            {
//                                name:'佣金',
//                                type:'line',
//                                data:total.commission
//                            }
//                        ]
//                    });
                } else {
                    bootbox.alert({
                        title: '<span class="text-danger">ERROR!</span>',
                        message: '获取数据失败!',
                    });
                }
            }
        });
        function flash_back(str){
            var a = str;
            for (var i=0;i<0;i++) {
                a.unshift(this[i]);
            }
            return a.join("");
        }
    });
</script>
