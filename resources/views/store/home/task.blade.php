<div class="card card-default">
    <!-- Default panel contents -->
    <div class="card-header">待处理事务</div>
    <div class="container-fluid">
        <div class ="row">
            <div class="col-md-12">
                <a href="#">
                    <span>待支付订单&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                    <span class = "badge badge-sm label-danger">&nbsp;&nbsp;{{$waitPayNum}}&nbsp;&nbsp;</span>
                </a>
            </div>
        </div>
        <div class ="row">
            <div class="col-md-12">
                <a href = "#">
                    <span>已完成订单&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                    <span class = "badge badge-sm label-warning">&nbsp;&nbsp;{{$completeNum}}&nbsp;&nbsp;</span>
                </a>
            </div>
        </div>
        <div class ="row">
            <div class="col-md-12">
                <a href="#">
                    <span>待发货订单&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                    <span class = "badge badge-sm label-primary" >&nbsp;&nbsp;{{$waitSendNum}}&nbsp;&nbsp;</span>
                </a>
            </div>
        </div>
        <div class ="row">
            <div class="col-md-12">
                <a href="#">
                    <span>已发货订单&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                    <span class = "badge badge-sm label-success" >&nbsp;&nbsp;{{$waitReceiveNum}}&nbsp;&nbsp;</span>
                </a>
            </div>
        </div>
    </div>
</div>