<div class="audit_top_style">
    <div class="audit_per_info">个人信息</div>
    <div class="audit_div_spacing">头像:
        <img src="" class="audit_per_img"></div>
    <div class="audit_div_spacing">
        <div class="audit_div_width">昵称:
            <div class="audit_div_text audit_nickname"></div>
        </div>
        <div class="audit_div_width">姓名:
            <div class="audit_div_text audit_username"></div>
        </div>
        <div class="audit_div_width">id:
            <div class="audit_div_text audit_user_id"></div>
        </div>
    </div>
    <div class="audit_div_spacing">
        <div class="audit_div_width">手机号:
            <div class="audit_div_text audit_phone"></div>
        </div>
        <div class="audit_div_width">微信:
            <div class="audit_div_text audit_wechat"></div>
        </div>
        {{--<div class="audit_div_width">支付宝:--}}
        {{--<div class="audit_div_text audit_alipay"></div>--}}
        {{--</div>--}}
    </div>
    <div class="audit_div_spacing">
        <div class="audit_div_text audit_div_left">下级:
            <div class="audit_div_text audit_total_per">总共</div>
        </div>
        <div class="audit_div_text audit_div_left audit_div_left_one">一级:
            <div class="audit_div_text audit_one_per"></div>
        </div>
        <div class="audit_div_text audit_div_left audit_div_left_two">二级:
            <div class="audit_div_text audit_two_per"></div>
        </div>
        <div class="audit_div_text audit_div_left audit_div_left_thr">三级:
            <div class="audit_div_text audit_thr_per"></div>
        </div>
    </div>
    <div class="audit_div_spacing">
        <div class="audit_div_text audit_div_left">比例: </div>
        <div class="audit_div_text audit_div_left">一级佣金比例:
            <div class="audit_div_text audit_one_com"></div>
        </div>
        <div class="audit_div_text audit_div_left">二级佣金比例:
            <div class="audit_div_text audit_two_com"></div>
        </div>
        <div class="audit_div_text audit_div_left">三级佣金比例:
            <div class="audit_div_text audit_thr_com"></div>
        </div>
    </div>
    <div class="audit_div_spacing">
        <span class="audit_info_status">状态:</span>
    </div>
</div>
<hr>
<div class="audit_detail_info"><span style="float:left;">提现详情</span>
    <div class="audit_alipay_account"></div>
</div>
<div class="tree well">
    <div style="margin: 0 0 15px 0;"></div>
    <ul id="top">
        <li>
                <span>
                    <i class="icon-folder"></i>
                    <span style="padding:0 0 0 25px;">订单号</span>
                    <span style="padding:0 0 0 45px;">申请时间</span>
                    <span style="padding:0 0 0 30px;">申请金额</span>
                    <span style="margin:0 0 0 10px;">已打款</span>
                    <span style="margin:0 0 0 20px;">待打款</span>
                    <span style="margin:0 0 0 40px;">打款完成时间</span>
                    <span style="padding:0 0 0 50px;">状态</span>
                </span>
        </li>
    </ul>
    <ul>
        <li>
                <span>
                    <span style="width:75px;text-align: center;" id="audit_pay_id"></span>
                    <span style="width:135px;text-align: center;" id="audit_time_start"></span>
                    <span style="width:60px;text-align: center;" id="audit_amount_apply"></span>
                    <span style="width:50px;text-align: center;" id="audit_tran">0.00</span>
                    <span style="width:50px;text-align: center;" id="audit_wait"></span>
                    <span style="width:130px;text-align: center;" id="audit_pay_time"> - </span>
                    <span style="width:70px;text-align: center;" id="audit_pay_status">待审核</span>
                </span>
            <ul style="border-radius:5px;" class="audit_list_rows"></ul>
        </li>
    </ul>

</div>
<div class="btn bootbox-close-button audit_btn_close" style="">确定</div>
<style>
    .audit_alipay_mobile {
        float:left;
        margin-left:20px;
    }
    .audit_pay_id {
        width:75px;
        text-align: center;
    }
    .audit_time_start {
        width:135px;
        text-align: center;
    }
    .audit_amount_apply {
        width:70px;
        text-align: center;
    }
    .audit_tran {
        width:50px;
        text-align: center;
    }
    .audit_wait {
        width:50px;
        text-align: center;
    }
    .audit_pay_time {
        width:140px;
        text-align: center;
    }
    .audit_pay_status {
        width:65px;text-align: center;
    }
    .audit_pay_type {
        width:80px;text-align: center;
    }
    .modal-content {
        padding-bottom: 50px;;
    }
    .audit_btn_close {
        float: right;
        margin: 10px 20px 20px 0;
        border: 1px solid rgba(0, 0, 0, 0.3);
        border-radius: 5px;
    }
    .audit_btn_close:hover {
        background-color: #dddddd;
    }
    .audit_detail_info {
        padding-top: 20px;
        padding-left: 20px;
        padding-bottom: 30px;
        background-color: #eee;
        border-radius: 5px;color:#979797;
    }
    .audit_top_style {
        border:1px solid #eeeeee;
        color:#979797;
    }
    .modal-dialog {
        width: 860px;
    }
    .tree {
        min-height: 20px;
        padding: 19px;
        margin-bottom: 20px;
        background-color: #fbfbfb;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        border-radius: 4px;
        -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);
        -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);
        box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05)
    }
    .tree li {
        list-style-type: none;
        margin: 0 0 0 -40px;
        position: relative
    }
    .tree li::before, .tree li::after {
        left: -20px;
        position: absolute;
        right: auto
    }
    .tree li::before {
        bottom: 50px;
        height: 100%;
        top: 0;
    }
    .tree li::after {
        height: 20px;
        top: 25px;
    }
    .tree li span {
        border-radius: 5px;
        display: inline-block;
        padding: 2px 2px;
        text-decoration: none
    }
    .tree li.parent_li>span {
        cursor: pointer;
    }
    .tree>ul>li::before, .tree>ul>li::after {
        border: 0
    }
    .tree li:last-child::before {
        height: 30px
    }
    .tree li.parent_li>span:hover, .tree li.parent_li>span:hover+ul li span {
        background: #eee;
    }
    .parent_li span {
        margin: 2px 10px 2px 10px;
    }
    .parent_li ul {
        background: #eee;
    }
    #top li span span {
        margin: 0 15px 0 15px;
    }
    .audit_div_spacing {
        color:#000000;
        padding-left: 20px;
        margin-top: 15px;
        margin-bottom: 10px;
    }
    .audit_per_img {
        width: 40px;
        height: 40px;
        border-radius: 100px;
        margin-left: 30px;
    }
    .audit_per_info {
        padding-bottom: 20px;
        padding-left: 20px;
        padding-top: 20px;
        background-color: #eeeeee;
    }
    .audit_div_width {
        display: inline-block;
        width: 200px;
    }
    .audit_div_text {
        text-align: center;
        display: inline-block;
    }
    .audit_div_left {
        margin-right: 27px;
    }
    .audit_pay_true:hover {
        background-color:#23BEF8;
    }
    .audit_pay_false:hover {
        background-color:#23BEF8;
    }
</style>
<script>
    $(".modal-footer").remove();
</script>