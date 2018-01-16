 <style type="text/css">
    fieldset{padding:.35em .625em .75em;margin:0 2px;border:1px solid silver;border-radius:8px;font-size: 13px;}
    legend{padding:.5em;border:0;width:auto;margin-bottom:10px; font-size: 13px;}
 </style>
 <div class="box-body">
    <form class="form-horizontal" id="commission_form" autocomplete="off">
    	<fieldset>
        	<legend>佣金设置</legend>
            <div class="form-group">
                <label class="col-sm-2 control-label">自购佣金：</label>
                <div class="col-sm-4" style="margin-top: 5px;">
                    <input type="checkbox" 
                           value="0" 
                           data-on-color="success" 
                           id="commission_status" 
                           class="bt-switch-commission" 
                           name="commission_status" />
                    <br />
                </div>
                <div class="col-sm-6"></div>
            </div>
             <div class="form-group">
                <label class="col-sm-2 control-label">分销层级：</label>
                <div class="col-sm-4" style="margin-top: 5px;">
                    <select name="level" id="level" class="form-control" required>
                        <option value="1">一级下线</option>
                        <option value="2">二级下线</option>
                        <option value="3">三级下线</option>
                    </select>
                </div>
                <div class="col-sm-6"></div>
            </div>
             <div class="form-group">
                <label class="col-sm-2 control-label" style="margin-top: 33px;">佣金比例设置：</label>
                <div class="col-sm-10" style="height:100px;">
                    <div style="width: 130px; height:100px; border:1px solid black; float:left; font-size:16px; margin-right: 35px; display: none;" id="commission_show" >
                        <span style="width:130px; height:50px; line-height: 50px; margin-left: 12px;" >
                            <img src="/images/u541.png" /><span style="margin-left: 6px;">自购</span>
                        </span>
                        <div style="margin-left: 40px;">
                            <input type="number" name="commission" value="0" min="0" max="100" class="input" style="border-radius: 5px; " /><span style="width: 25px; height: 24px; background: #b9a0a0;  padding:2px;">%</span>
                        </div>
                    </div>
                    
                    <div id="commission_precent">
                        <div style="width: 130px; height:100px; border:1px solid black; float:left; font-size:16px;">
                            <span style="width:130px; height:50px; line-height: 50px; margin-left: 12px;" id="one">
                                <img src="/images/u541.png" /><span style="margin-left: 6px;">一级分销商</span>
                            </span>
                            <div style="margin-left: 40px;">
                                <input type="number" name="father_commission" value="0" min="0" max="100" class="input" style="border-radius: 5px; " /><span style="width: 25px; height: 24px; background: #b9a0a0;  padding:2px;">%</span>
                            </div>
                        </div>
                        <div id="two" style="display: none;">
                            <div style="float:left; margin-top:40px; margin-right: -10px;">
                                <img src="/images/u597.png" >
                            </div>
                            <div style="width: 130px; height:100px; border:1px solid black; float:left; font-size:16px;">
                                <span style="width:130px; height:50px; line-height: 50px; margin-left: 12px;">
                                    <img src="/images/u541.png" /><span style="margin-left: 6px;">二级分销商</span>
                                </span>
                                <div style="margin-left: 40px;">
                                    <input type="number" name="grand_father_commission" value="0" min="0" max="100" class="input" style="border-radius: 5px;" /><span style="width: 25px; height: 24px; background: #b9a0a0;  padding:2px;">%</span>
                                </div>
                            </div>
                        </div>
                        <div id="three" style="display: none;">
                            <div style="float:left; margin-top:40px; margin-right: -10px;">
                                <img src="/images/u597.png" >
                            </div>
                            <div style="width: 130px; height:100px; border:1px solid black; float:left;">
                                <span style="width:130px; height:50px; line-height: 50px; margin-left: 12px;">
                                    <img src="/images/u541.png" /><span style="margin-left: 6px;">三级分销商</span>
                                </span>
                                <div style="margin-left: 40px;">
                                    <input type="number" name="great_grand_father_commission" value="0" min="0" max="100" class="input" style="border-radius: 5px; " /><span style="width: 25px; height: 24px; background: #b9a0a0;  padding:2px;">%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">佣金结算天数：</label>
                <div class="col-sm-4">
                    <input type="text" name="commission_days" class="form-control" placeholder="佣金结算天数" required>
                </div>

                <div class="col-sm-6"></div>
                <br><br>
                <font color="green" style="margin-top:15px; margin-left: 180px; line-height: 35px;">交易完成后需要再等x天再给分销商结算佣金.建议设置为售后周期后</font>
            </div>
        </fieldset>
         <div class="form-group">
            <div class="col-sm-10 col-sm-offset-4">
                <button class="btn btn-primary" style="margin:5px 10px 5px 80px;">保存修改</button>
            </div>
        </div>
    </form>
</div>
@push('js')
<script type="text/javascript">
    $('#commission_form').validator().on('submit', function (e) {
        if(!e.isDefaultPrevented()){
            e.preventDefault();
            var newData = {
                commission_status: 0

            }
            data = $(e.target).serializeArray();
            data.map(function (item) {
                newData[item['name']] = item['value'];
            })
            $.ajax({
                type: "POST",
                url: '/ajax/shop/fenxiao/setting/store',
                data: newData,// 你的formid
                async: false,
                error: function(request) {
                    if(request.error) {
                         bootbox.alert(request.error);
                    }
                   
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
                    } else if(json.code == 401) {
                        bootbox.alert({
                            title: '<span class="text-success">用户认证失败</span>',
                            message: '由于长时间未操作，请重新登录',
                            callback: function () {
                                location.pathname = "/login";
                            }
                        });
                    } else {
                        bootbox.alert({
                            title: '<span class="text-success">操作失败</span>',
                            message: json.error
                        });
                    }
                }
            });
        } else {
            bootbox.alert({
                title: '<span class="text-success">提交</span>',
                message: '请填写必填项',
            });
        }
        return false;
    });
    var inputObj = document.getElementsByClassName("input");
    for(var i= 0; i<inputObj.length; i++){
        inputObj[i].addEventListener('keydown', function(e) {
            var oldnum = parseInt(this.value);
            if (e.keyCode >= 48 && e.keyCode <= 57) {
                var oldnum = this.value;
                var num = e.keyCode - 48;
                var v = oldnum.toString() + num;
                v = parseInt(v);
                if (v < 0 || v > 100) {
                    alert('值需在0-100范围之内');
                    this.value = oldnum;
                    e.preventDefault();
                } else {
                    return true;
                }
            }else{
                if(e.keyCode!=8){
                    this.value=oldnum;
                    e.preventDefault();
                    return false;
                }
                 
            }
        });
    }
    $(document).ready(function () {
        $('.bt-switch-commission').bootstrapSwitch({onText:"开启",offText:"关闭"}).on('switchChange.bootstrapSwitch', function(event, status){
            this.value = status ? 1: 0;
            if(this.value == 1) {
                $('#commission_show').show();

            } else {
                $('#commission_show').hide();
            }
        });
        $("#level").change(function(){ 
            if($(this).val() == 1) {
                $("#commission_precent").show();
                $('#two').hide();
                $('#three').hide();

            } else if($(this).val() == 2) {
                $("#commission_precent").show();
                $('#two').show();
                $('#three').hide();

            } else if($(this).val() == 3) {
                $("#commission_precent").show();
                $('#two').show();
                $('#three').show();

            } else {
                $("#commission_precent").hide();
            }
        });

        $.getJSON('/ajax/shop/fenxiao/commissionSet',function (json) {
            var data = json.data[0];
            if(data){
                $('#level [value=' + data.level + ']').attr('selected','selected');
                $("#level").change();
                $('#commission_form [name=father_commission]').val(data.father_commission);
                $('#commission_form [name=grand_father_commission]').val(data.grand_father_commission);
                $('#commission_form [name=great_grand_father_commission]').val(data.great_grand_father_commission);
                $('#commission_form [name=commission_days]').val(data.commission_days);
                $('#commission_form [name=commission]').val(data.commission);
                $('#commission_status').bootstrapSwitch('state',data.commission_status);
                if(data.commission_status === 0) {
                     $('#commission_show').hide();
                }
            }
        });
    });
</script>
@endpush
