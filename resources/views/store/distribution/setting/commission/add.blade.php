<!-- /*查看某分销等级佣金详情 */ -->
<style>
    #commission_title{ margin-top: 8px; }
    #commission_title>div{ height: 60px;}
    #self_commission{ width: 90px; height:60px; border:1px solid black; float:left; font-size:12px; margin-right: 12px; }
    #self_commission>span{width:90px; height:50px; line-height: 25px;}
    #self_commission>span>label{ margin-left: 26px; }
    #self_commission>div{ margin-left: 15px; }
    #self_commission>div>input{ border-radius: 5px; }
    #father_commission{ width: 90px; height:60px; border:1px solid black; float:left; font-size:12px; }
    #father_commission>span{ width:90px; height:50px; line-height: 25px; }
    #father_commission>span>label{ margin-left: 18px; }
    #father_commission>div{ margin-left: 15px; }
    #father_commission_input{ border-radius: 5px; }
    #gf_commission>div{ width: 90px; height:60px; border:1px solid black; float:left; font-size:12px; margin-left: 12px; }
    #gf_commission>span{ width:90px; height:50px; line-height: 25px; margin-left: 12px; }
    #gf_commission>span>label{ margin-left: 6px; }
    #gf_commission #grand_father_commission_input_box{ margin-left: 15px; }
    #grand_father_commission_input{ border-radius: 5px; }
    #ggf_commission>div{ width: 90px; height:60px; border:1px solid black; float:left; margin-left: 12px; }
    #ggf_commission>div>span{ width:90px; height:50px; line-height: 25px; margin-left: 12px; }
    #ggf_commission>div>span>label{ margin-left: 6px; }
    #ggf_commission>div>div{ margin-left: 15px; }
    #ggf_commission input{border-radius: 5px;}
</style>
<form id="edit_form">
    <fieldset>
        <div class="form-group col-sm-12">
            <label class="col-sm-2 control-label" for="level_name">级别</label>
            <div class="col-sm-6">
                <span id="level_no"></span>
            </div>
        </div>
        <div class="form-group col-sm-12">
            <label class="col-sm-2 control-label">等级名称</label>
            <div class="col-sm-4">
                <span>
                    <input type="text" name="level_name" id = "level_name" class="form-control">
                </span>
            </div>
        </div>
        <div class="form-group col-sm-12">
            <label class="col-sm-2 control-label">升级规则</label>
            <span class="col-sm-3">
                <input type="radio" name="upgrade_type" value="0" id="no_auto_update">
                <label for="no_auto_update">不自动升级</label>
            </span>
            <span class="col-sm-7">
                <input type="radio" name="upgrade_type" value="1" id="upgrade">
                <label for="upgrade">满额升级&nbsp;&nbsp;&nbsp;累计已结算佣金满</label>
                <span class="input-group form-group">
                    <input id = "upgrade" type="number" value="0" name="reach_amount" min="0" class="form-control input-s" tabindex="4">
                    <span class="input-group-addon">元</span>
                </span>
            </span>
        </div>
        <div class="form-group  col-sm-12" id="precent">
            <label class="col-sm-2 control-label" id = "commission_title" >设置佣金：</label>
            <div class="col-sm-10" >
                <div  id="self_commission">
                    <span>
                        <label for="commission" >自购</label>
                    </span>
                    <div >
                        <input type="number" name="commission" id = "commission" value="0" min="0" max="100" />
                        <span class="precent">%</span>
                    </div>
                </div>
                <div id = "father_commission_box">
                    <div  id="father_commission">
                        <span >
                            <label for="father_commission_input" >一级上线</label>
                        </span>
                        <div >
                            <input type="number" name="father_commission" id = "father_commission_input" value="0" min="0" max="100" />
                            <span class="precent">%</span>
                        </div>
                    </div>
                    <div id="gf_commission">
                        <div >
                            <span>
                                <label for="grand_father_commission_input">二级上线</label>
                            </span>
                            <div id = "grand_father_commission_input_box">
                                <input type="number" name="grand_father_commission" id = "grand_father_commission_input" value="0" min="0" max="100" />
                                <span class="precent">%</span>
                            </div>
                        </div>
                    </div>
                    <div id="ggf_commission">
                        <div >
                            <span >
                                <label for="great_grant_father_commission" >三级上线</label>
                            </span>
                            <div >
                                <input type="number" name="great_grand_father_commission" id = "great_grant_father_commission" value="0" min="0" max="100" />
                                <span class="precent">%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </fieldset>
</form>
<script type="text/javascript">
    let commissionLevel = window['commissionLevel'];
    if( commissionLevel['level'] ){
        $('#level_no').text( commissionLevel['level'] );
        $('#edit_form[name=level_name]').val(commissionLevel['name']);
        $('#edit_form[name=upgrade_type][value='+ commissionLevel.upgrade_type +']').attr('checked', 'checked');
        if(commissionLevel.upgrade_type === 1){
            $('#edit_form[name=reach_amount]').val(commissionLevel.reach_amount);
        }
    } else {
        $('#level_no').text( parseInt($(`#body2 tr:last td:eq(0)`).text()) + 1) ;
    }
    if(commissionLevel['level'] === 1){
        $('#father_commission[name=father_commission]').val(commissionLevel['father_commission']);
        $('#gf_commission').hide();
        $('#ggf_commission').hide();
    } else if(commissionLevel['level'] === 2) {
        $('#father_commission[name=father_commission]').val(commissionLevel['father_commission']);
        $('#gf_commission[name=grand_father_commission]').val(commissionLevel['grand_father_commission']);
        $('#ggf_commission').hide();
    } else {
        $(`#father_commission[name=father_commission]`).val(commissionLevel['father_commission']);
        $('#gf_commission[name=grand_father_commission]').val(commissionLevel['grand_father_commission']);
        $('#ggf_commission[name=great_grand_father_commission]').val(commissionLevel['great_grand_father_commission']);
    }
    if(commissionLevel['commission_status'] === 0) {
        $('#self_commission').hide();
    } else {
        $('#self_commission[name=commission]').val(commissionLevel['commission']);
    }
</script>
<!-- 选中分销等级，进行等级佣金设置end -->