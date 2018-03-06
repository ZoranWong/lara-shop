<style>
    .chart-panel-width{width: 1000px;}
    .chart-panel-body-width{width: 800px;}
    .chart-panel-width .chart-panel-main{width:900px;height: 300px;}
</style>
<div class="row col-sm-12">
    <div class="row col-lg-6 chart-panel-width" >
        <section class="panel panel-default">
            <div class="panel-body chart-panel-body-width">
                <div id="main" class="chart-panel-main"></div>
            </div>
        </section>
    </div>
</div>
<script src=" https://cdn.bootcss.com/echarts/4.0.4/echarts-en.common.min.js"></script>

<script type="text/javascript">
    window.pageInit = function() {
        $.ajax({
            type: 'GET',
            url: '/ajax/distribution/order/statics',
            data: '',
            error: function () {
                bootbox.alert({
                    title: '<span class="text-danger">ERROR!</span>',
                    message: '请求失败!',
                });
            },
            success: function (msg) {
                if (msg.code === 200) {
                    let total = msg.data;
                    let day = total.day;
                    let amount = total.amount;
                    let commission = total.commission;
                    let member = total.member;
                    let orders = total.orders;
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
                    let myChart = echarts.init(document.getElementById('main'));

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
                } else {
                    bootbox.alert({
                        title: '<span class="text-danger">ERROR!</span>',
                        message: '获取数据失败!',
                    });
                }
            }
        });
    };
</script>
