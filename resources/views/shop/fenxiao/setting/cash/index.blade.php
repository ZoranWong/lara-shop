 <style type="text/css">
    fieldset{padding:.35em .625em .75em;margin:0 2px;border:1px solid silver;border-radius:8px;font-size: 13px;}
    legend{padding:.5em;border:0;width:auto;margin-bottom:10px; font-size: 13px;}
 </style>
 <div class="box-body">
    <form class="form-horizontal" id="cash_form" autocomplete="off">
        <div class="form-group">
            <label class="col-sm-4 control-label" style="margin:10px;">最小提现金额：</label>
            <div class="col-sm-5" style="margin:10px;">
                <input type="text" name="min_cash_num" class="form-control" placeholder="输入最小提现金额">
            </div>
            <div class="col-sm-4"></div>
            <div class="col-sm-6" style="margin-left:40px;"><font color="red">注: 用户提现时必须超过此金额才可提现，单位：元。</font></div>

        </div>
         <div class="form-group">
            <div class="col-sm-10 col-sm-offset-4">
                <button class="btn btn-primary" id="cash_submit" style="margin:5px 10px 5px 80px;">保存修改</button>
            </div>
        </div>
    </form>
</div>
@push('js')
<script type="text/javascript">
    $('#cash_submit').click(function (){
        $.ajax({
            type: "POST",
            url:'/ajax/shop/fenxiao/commissionToCashHandler',
            data:$('#cash_form').serialize(),// 你的formid
            async: false,
            error: function(request) {
                alert("Connection error");
            },
            success: function(json) {
               if(json.code == 200) {
                    bootbox.alert({
                        title: '<span class="text-success">成功</span>',
                        message:'更新成功',
                        callback: function () {
                            location.pathname = "/shop/fenxiao/setting";
                        }
                    });
                } else {
                    bootbox.alert({
                        title: '<span class="text-success">操作失败</span>',
                        message: json.error,
                    });
                }
            }
        });
        return false;
    });
    $(document).ready(function () {
        $.getJSON('/ajax/shop/fenxiao/commissionToCash',function (json) {
            var data = json.data[0].min_cash_num;
            $('#cash_form input[name=min_cash_num]').val(data/100);

        });
    });
</script>
@endpush
