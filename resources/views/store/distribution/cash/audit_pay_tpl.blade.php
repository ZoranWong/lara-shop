<div>打款进度:</div>
<div id="audit_pay_cash_id" hidden></div>
<div id="audit_pay_fans_id" hidden></div>
<div class="audit_pay_info">
    <div>提现金额</div>
    <div>已打款</div>
    <div>待打款</div>
    <div class="audit_amount_extract"></div>
    <div class="audit_amount_push">0.00</div>
    <div class="audit_amount_wait"></div>
</div>
<div class="audit_pay_type_info">
    <div class="audit_extract_no">提现账号 :</div>
    <div class="audit_pay_mobile_set">
        <span>支付宝 :</span>
        <span><input type="text" name="mobile" id="autit_alipay_account"></span>
    </div>
</div>
<div class="audit_operation">
    <div class="audit_pay_false bootbox-close-button">取消</div>
    <div class="audit_pay_true">打款</div>
</div>
<style>

    .audit_pay_true:hover {
        background-color:#23BEF8;
    }
    .audit_pay_mobile_set span {
        margin-left:15px;
    }
    .audit_pay_mobile_set {
        margin-top: 25px;
        padding-left: 30px;
    }
    .audit_pay_type_info {
        margin-top:130px;
    }
    .modal-body {
        border-top:1px white solid;
        width:800px;
        height:360px;
        margin:0 auto;
    }
    .audit_pay_info {
        margin:left;
        margin-top:50px;
    }
    .audit_pay_info div {
        width:255px;
        padding:5px 0 5px 0;
        float:left;
        border:1px solid #d3d3d3;
        text-align:center;
    }
    .audit_pay_false {
        float:left;
        margin-right:20px;
        padding:5px 10px 5px 10px;
        border:1px solid #d3d3d3;
        border-radius:5px;
        cursor:pointer;
    }
    .audit_pay_true {
        float:left;
        padding:5px 10px 5px 10px;
        border:1px solid #23BEF8;
        background-color:#23BEF8;
        border-radius:5px;
        cursor:pointer;
    }
    .audit_pay_true:hover {
        background-color:white;
    }
    .audit_operation {
        float:right;
        width:150px;
        padding-top:90px;
    }
    input[type=radio] {
        margin-left:150px;
    }
    .modal-body {
        height:380px;
    }
</style>
<script>
    $(".modal-footer").remove();
    var audit_pay_timeout;
    $('.audit_pay_false').click(function() {
        if (audit_pay_timeout) {
            clearTimeout(audit_pay_timeout);
            audit_pay_timeout = null;
        }
    });
    /*提交打款申请*/
    $('.audit_pay_true').click(function() {
        var audit_pay_fans_id = $("#audit_pay_fans_id").text();
        //  小程序默认商家自行转账给分销商 转账成功后商家更改打款状态
//            var audit_pay_type = $('input[name=audit_pay_type]:checked').val();
        var audit_pay_cash_id = $('#audit_pay_cash_id').text();
        var audit_alipay = $('#autit_alipay_account').val();
        if(audit_alipay == ""){
            bootbox.alert({
                title: '<span class="text-danger">打款进度</span>',
                message: "<div style='margin: 0 auto;text-align: center;font-size: 20px;margin-top: 10%;'>提现账号不能为空!</div>"
            });
            return false;
        }
        var audit_is_account = audit_alipay.match(/[.-_|a-zA-Z0-9]{1,}/);
        var audit_is_mail = audit_alipay.match(/^([a-zA-Z0-9|_.-])+@(([a-zA-Z0-9|-])+.)+([a-zA-Z0-9]{2,4})/);
        if (audit_is_account == null && audit_is_mail == null) {
            bootbox.alert({
                title: '<span class="text-danger">打款进度</span>',
                message: "<div style='margin: 0 auto;text-align: center;font-size: 20px;margin-top: 10%;'>账号格式不正确!</div>"
            });
            return false;
        } else if (audit_is_account == null && audit_alipay != audit_is_mail[0]) {
            bootbox.alert({
                title: '<span class="text-danger">打款进度</span>',
                message: "<div style='margin: 0 auto;text-align: center;font-size: 20px;margin-top: 10%;'>账号格式不正确!</div>"
            });
            return false;
        } else if (audit_alipay != audit_is_account[0] && audit_is_mail == null) {
            bootbox.alert({
                title: '<span class="text-danger">打款进度</span>',
                message: "<div style='margin: 0 auto;text-align: center;font-size: 20px;margin-top: 10%;'>账号格式不正确!</div>"
            });
            return false;
        }
        /*如果10秒内未响应 则返回超时*/
        audit_pay_timeout = setTimeout(function() {
            bootbox.alert({
                title: '<span class="text-danger">打款进度</span>',
                message: "<div style='margin: 0 auto;text-align: center;font-size: 20px;margin-top: 10%;'>超时!</div>"
            });
        }, 10000);

        $.post('/ajax/shop/fenxiao/cash/pay/member', {'cash_id': audit_pay_cash_id,'fans_id': audit_pay_fans_id,'alipay_account':audit_alipay,'status': 2},function(json) {
            if (json.code == 200) {
                if (audit_pay_timeout) {
                    clearTimeout(audit_pay_timeout);
                    audit_pay_timeout = null;
                }
                var tab;
                tab = "<div style='margin: 0 auto;text-align: center;font-size: 20px;margin-top: 10%;'>成功!</div>";
                tab += "<div class='audit_close_btn' style='width: 60px;text-align: center;margin: 0 auto; padding:5px 5px;margin-top: 30px;border: 1px solid #d3d3d3;border-radius: 5px;'>确定</div>";
                tab += '<style>.audit_close_btn:hover{cursor: pointer;background-color: #00a0e9}</style>';
                tab += '<script>';
                tab += '$(".modal-footer").remove();';
                tab += '$(".audit_close_btn").click(function(){history.go(0)});';
                tab += '<'+'/script>';
                bootbox.alert({
                    title: '<span class="text-success">打款进度</span>',
                    message: tab
                });
            }
        });
    });
</script>