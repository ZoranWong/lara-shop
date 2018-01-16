<style>
    .goods{
        width: 64px;
        height: 64px;
        border: 1px solid #e0e0e0;
    }
</style>
<div id = "edit_activity_page" class = "row" style = "margin-bottom: 36px;">
    <h2 class = "opt-title">设置拼团活动</h2>
    <div class="form-box pull-right col-md-10">
        <form role = "form" class="form-horizontal add-groupon-activity" onsubmit="return false;" >
            <div class="form-group select-goods-group" >
                <label class="col-sm-2 control-label required" for="platform_title">选择商品：</label>
                <div class="col-sm-5 ">
                    <input type="hidden" class="form-control " type = "number" name="goods_id" value="" required/>
                    <div class="goods">
                        <div class = "img-box goods-image-box" style="width: 100%;height: 100%;">
                            <img  style="width: 100%;height: 100%;" src="" hidden = "hidden">
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label required" for="platform_title">活动名称：</label>
                <div class="col-sm-5 ">
                    <input type="text" class="form-control " name="activity_name" value="" placeholder="团购活动名称" required/>
                </div>
            </div>
            <div class="form-group activity-date" >
                <label class="col-sm-2 control-label required" for="platform_title">有效时间：</label>
                <div class = "col-sm-5">
                    <div  style="display: flex;width: 100%;">
                        <div style="width: 45%;position: relative;">
                            <input type="datetime" class="form-control  start-datepicker" name="start_time" placeholder="团购活动开始时间" required>
                            <input  class="form-control datepicker start-datepicker-1" name="start_time" placeholder="团购活动开始时间" >
                        </div>
                        <div style="width: 10%;height: 100%;text-align: center;vertical-align: middle;margin-top: 6px;">至</div>
                        <div style="width: 45%;position: relative;">
                            <input type="datetime"  class="form-control end-datepicker" name="end_time" placeholder="团购活动结束时间" required>
                            <input  class="form-control datepicker end-datepicker-1" name="end_time" placeholder="团购活动结束时间" >
                        </div>
                    </div>
                    <span class = "tips">开始时间必须大于当前时间，结束时间不得小于开始时间。</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label required" for="platform_title">参团人数：</label>
                <div class="col-sm-5 ">
                    <input type="number" min ='2' max="100" step = "1" class="form-control " name="member_num" value="" placeholder="" required/>
                    <span class = "tips">请填写2-100之间的数字哦</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label " for="platform_title">商品限制：</label>
                <div class="col-sm-5" style="display: flex;">
                    <label class="control-label" for="platform_title"> <input class ="buy-limit-num-checkbox" type="checkbox" >开启限购</label>
                    <label class = "label-buy-limit" style="display: flex;">
                        <input type="number" min = "1" step="1" class="form-control " style="
                            padding: 0px 10px;
                            width: 72px;
                            margin-left: 8px;
                            height: 28px;
                            " name="buy_limit_num" value="1" placeholder="" />
                        <label style="
                            padding-top: 5px;
                            padding-left: 8px;
                            margin-bottom: 0;">个／人</label>
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="platform_title">凑团设置：</label>
                <div class="col-sm-5" >
                    <label class="control-label" for="platform_title"> <input class = "auto-patch-checkbox" name = "auto_patch" type="checkbox" >开启凑团</label>
                    <br>
                    <span class = "tips">开启凑团后，对于未参团的买家，活动商品详情页会显示未成团的团列表，买家可以直接任选一个参团，提升成团率。</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="platform_title">团长优惠：</label>
                <div class="col-sm-5" >
                    <label class="control-label" for="platform_title"> <input name = "leader_prefer" class = "leader-prefer-checkbox" type="checkbox">团长享受优惠价</label>
                    <br>
                    <span class = "tips">开启团长(开团人)优惠后，团长将享受更优惠价格，有助于提高开团率和成团率。</span>
                    {{--<br>--}}
                    {{--<span class = "tips tip-warning">请注意：模拟成团的团长也能享受团长优惠，请谨慎设置，避免资金损失。</span>--}}
                </div>
            </div>
            <div class="form-group groupon-activity-price" >
                <label class="col-sm-2 control-label price-label-title required" for="platform_title">优惠设置：</label>
                <div class="col-sm-10 groupon-product-price-box" >

                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-2 col-sm-offset-2">
                    <a class="btn  btn-default form-control cancel" href="javascript:void(0)" >取消</a>
                </div>
                <div class="col-sm-2">
                    <button class="btn btn-primary  form-control submit">保存</button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('js')
<script>
    $(document).ready(function () {
        editActivityController = {
            stage:$('#edit_activity_page'),
            leaderPreferOpen:false,
            limitSelected:true,
            data:{},
            show:false,
            autoPatch: true,
            running:function () {
                if(this.status == STATUS['RUNNING']){
                    this.endTimePicker.datetimepicker('setStartDate',this.data['start_format_time']);
                    this.stage.find('input').prop( "disabled", true );
                    this.stage.find('input[name="end_time"]').prop("disabled",false);
                }
            },
            notStart:function () {
                if(this.status == STATUS['NOT_START']){
                    this.startTimePicker.datetimepicker('setStartDate',(new Date()).format('yyyy-MM-dd hh:mm:ss'));
                    this.startTimePicker.datetimepicker('setEndDate',this.data['end_format_time']);
                    this.stage.find('input').prop( "disabled", false );
                    this.endTimePicker.datetimepicker('setStartDate',this.data['start_format_time']);
                }
            },
            dataRender:function (data) {
                this.stage.find('input[name="goods_id"]').val(data['goods_id']);
                this.stage.find('input[name="activity_name"]').val(data['activity_name']);

                if(data['auto_patch']){
                    this.stage.find('input[name="auto_patch"]').prop("checked", true);
                }else{
                    this.stage.find('input[name="auto_patch"]').prop("checked", false);
                }

                if(data['leader_prefer']){
                    this.stage.find('input[name="leader_prefer"]').prop("checked", true);
                }else{
                    this.stage.find('input[name="leader_prefer"]').prop("checked", false);
                }

                if(data['buy_limit_num'] > 0){
                    this.stage.find('input.buy-limit-num-checkbox').prop("checked", true);
                    this.showLimit();
                }else{
                    this.stage.find('input.buy-limit-num-checkbox').prop("checked", false);
                    this.hideLimit();
                }

                this.stage.find('input[name="start_time"]').val(data['start_format_time']);
                this.stage.find('input[name="end_time"]').val(data['end_format_time']);
                this.stage.find('input[name="buy_limit_num"]').val(data['buy_limit_num']);
                this.stage.find('input[name="member_num"]').val(data['member_num']);
                this.stage.find('input[name="price"]').val(data['price']/100)
                if(data['leader_prefer']){
                    //$('input[name="leader_price"]').show();
                    this.stage.find('.activity-leader-price').show();
                }else{
                    this.stage.find('.activity-leader-price').hide();
                }

                this.stage.find('.img-box img').attr('src',data['goods']['image_url']);
                this.stage.find('.img-box img').show();
            },
            showPrice:function ($originPrice,$stockNum) {
                this.stage.find('.groupon-activity-price').show();
                this.stage.find('.goods-origin-price').html($originPrice);
                this.stage.find('.goods-stock-num').html($stockNum);
                this.stage.find('.goods-activity-price').val('');
            },
            hidePrice:function () {
                this.stage.find('.groupon-activity-price').hide();
                this.stage.find('.goods-origin-price').html('');
                this.stage.find('.goods-stock-num').html('');
                this.stage.find('.goods-activity-price').val('');
            },
            showLimit:function(){
                this.stage.find('.label-buy-limit').show();
                this.stage.find('.label-buy-limit').val('');
                this.limitSelected = true;
            },
            hideLimit:function () {
                this.stage.find('.label-buy-limit').hide();
                this.limitSelected = false;
            },
            showLeaderPrice:function () {
                this.leaderPreferOpen = true;
                if(this.goods)
                    this.stage.find('.groupon-product-price-box').html(goodsTable(this.goods, this.leaderPreferOpen));
            },
            hideLeaderPrice:function () {
                this.leaderPreferOpen = false;
                if(this.goods)
                    this.stage.find('.groupon-product-price-box').html(goodsTable(this.goods, this.leaderPreferOpen));
            },
            startTime:function (event, datepicker) {
                var minuteMS = 1000 *60;
                this.data['start_time'] = parseInt(event.date.getTime() / minuteMS) * minuteMS;
                var error = this.data['start_time'] < Date.now() || (typeof this.data['end_time'] != 'undefined' &&
                    ( this.data['end_time'] < Date.now() || this.data['start_time'] > this.data['end_time']));
                if(error){
                    this.stage.find('.activity-date').addClass('has-error has-danger');
                }else{
                    this.stage.find('input.start-datepicker').val(event.date.format('yyyy-MM-dd hh:mm')+":00");
                    this.stage.find('.activity-date').removeClass('has-error has-danger');
                }
            },
            endTime:function (event, datepicker) {
                var minuteMS = 1000 *60;
                this.data['end_time'] =  parseInt(event.date.getTime() / minuteMS) * minuteMS;

                var error = this.data['end_time'] < Date.now() || (typeof this.data['start_time'] != 'undefined' &&
                    (this.status == STATUS['NOT_START'] && this.data['start_time'] < Date.now() || this.data['start_time'] > this.data['end_time']));
                if(error){
                    this.stage.find('.activity-date').addClass('has-error has-danger');
                }else{
                    this.stage.find('input.end-datepicker').val(event.date.format('yyyy-MM-dd hh:mm')+":00");
                    this.stage.find('.activity-date').removeClass('has-error has-danger');
                }
            },
            init:function () {
                dateTimeInit(this);
                var self = this;
                this.stage.on('click','.leader-prefer-checkbox',function () {
                    if(!self.leaderPreferOpen){
                        self.showLeaderPrice();
                        //self.stage.find('.groupon-product-price-box').html(goodsTable(self.goods, this.leaderPreferOpen));
                    }else{
                        self.hideLeaderPrice();
                        //self.stage.find('.groupon-product-price-box').html('');
                    }
                });

                this.stage.on('click','.auto-patch-checkbox',function () {
                    self.autoPatch = !self.autoPatch;
                });

                var limitNum = 1;
                this.stage.on('click','.buy-limit-num-checkbox',function () {
                    if(!self.limitSelected){
                        self.stage.find('input[name="buy_limit_num"]').val(limitNum);
                        self.showLimit();
                    }else{
                        limitNum = self.stage.find('input[name="buy_limit_num"]').val();
                        self.stage.find('input[name="buy_limit_num"]').val('');
                        self.hideLimit();
                    }
                });

                this.stage.on('change', '.groupon-product-price-box input', function (e) {
                    var target = $(e.target);
                    if(target.data('type') == 'goods'){
                        self.goods[target.data('name')] = target.val();
                    }else{
                        self.goods['products'][target.data('index')][target.data('name')] = target.val();
                        console.log(self.goods['products'][target.data('index')]);
                    }
                });

                this.stage.find('form').validator().on('submit', function (e) {
                    var data = $(e.target).serializeArray();
                    var canSubmit = true;
                    var temp = {};
                    $.each(data,function (index, value) {
                        if(value['name'] =='goods_id' ){
                            if(value['value'] == ''){
                                self.stage.find('.select-goods-group').addClass('has-error has-danger');
                                canSubmit &= false;
                            }else{
                                self.stage.find('.select-goods-group').removeClass('has-error has-danger');
                                canSubmit &= true;
                            }
                        }
                        if(value['value'] != ''){
                            temp[value['name']] = value['value'];
                        }

                    });
                    var error = (typeof self.data['end_time'] == 'undefined' || typeof self.data['start_time'] == 'undefined' || ((self.data['start_time']
                        > self.data['end_time']) || this.status == STATUS['NOT_START'] && self.data['start_time'] < Date.now() || self.data['end_time'] < Date.now()));
                    if(error){
                        self.stage.find('.activity-date').addClass('has-error has-danger');
                        canSubmit &= false;
                    }else{
                        self.stage.find('.activity-date').removeClass('has-error has-danger');
                        canSubmit &= true;
                    }

                    if(self.status == STATUS['NOT_START']) {
                        if(parseInt(temp['member_num']) >= 2 && parseInt(temp['member_num']) < 100){
                            canSubmit &= true;
                        }else{
                            canSubmit &= false;
                        }

//                        if(parseInt(temp['buy_limit_num']) >= 1){
//                            canSubmit &= true;
//                        }else{
//                            canSubmit &= false;
//                        }

                        function priceerror(data) {
                            if(typeof data['price'] != 'undefined'){
                                if(data['price'] == "" || data['sell_price'] == "" || parseFloat(data['price']) > parseFloat(data['sell_price']) || parseFloat(data['price']) <= 0){
                                    return false;
                                }else{
                                    if(typeof data['leader_price'] != 'undefined'){
                                        if ( data['price'] == "" || data['sell_price'] == "" ||  parseFloat(data['leader_price']) > parseFloat(data['price']) ||(self.leaderPreferOpen && parseFloat(data['leader_price']) <= 0)){
                                            return false;
                                        }else{
                                            return true;
                                        }
                                    }else{
                                        return true;
                                    }
                                }
                            }else{
                                return false;
                            }
                        }

                        function priceGrouponError(state, type, id) {
                            if(!state){
                                self.stage.find('.groupon-activity-price').addClass('has-error has-danger');
                                self.stage.find('.groupon-activity-price .'+type+"-price-"+id).addClass('has-error has-danger');
                                self.stage.find('.groupon-activity-price .'+type+"-leader-price-"+id).addClass('has-error has-danger');
                            }else{
                                self.stage.find('.groupon-activity-price').removeClass('has-error has-danger');
                                self.stage.find('.groupon-activity-price .'+type+"-price-"+id).removeClass('has-error has-danger');
                                self.stage.find('.groupon-activity-price .'+type+"-leader-price-"+id).removeClass('has-error has-danger');
                            }
                        }

                        temp['products'] = {};
                        var canSubmit1 = true;
                        if(self.goods['products'] && self.goods['products'].length > 0){
                            $.each(self.goods['products'], function(index, product){
                                if(canSubmit1)
                                    canSubmit1 = priceerror(product);
                                priceGrouponError(priceerror(product), 'products', product['id']);
                                $product = {id:product['id'],'price':product['price'] * 100};
                                if(self.leaderPreferOpen){
                                    $product['leader_price'] = product['leader_price'] * 100;
                                }
                                temp['products']['_'+$product['id']] = $product ;
                            });
                        }else{
                            priceGrouponError((canSubmit1 = priceerror(self.goods)),'goods', self.goods['id']);
                            temp['price'] = self.goods['price'] * 100;
                            if(self.leaderPreferOpen){
                                temp['leader_price'] = self.goods['leader_price'] * 100;
                            }
                        }

                        canSubmit &=canSubmit1;

                    }
                    if(!canSubmit){
                        self.stage.find('.submit').removeAttr('disabled');
                        self.stage.find('.submit').text('保存');
                        return;
                    }

                    self.stage.find('.submit').attr('disabled', 'disabled');
                    self.stage.find('.submit').text('保存中...');



                    if(self.status == STATUS['NOT_START']){
                        temp['auto_patch'] = self.autoPatch ? 1 : 0;
                        !self.leaderPreferOpen ? (delete temp['leader_prefer']) : (temp['leader_prefer'] = 1);
                        temp['start_time'] = self.data['start_time']/1000;
                    }

                    temp['end_time'] = self.data['end_time']/1000;


                    HttpUtils.put('/ajax/shop/activity/groupon/'+self.id,temp).done(function(json){
                        if(json.code == 200 && json.success ){
                            bootbox.alert({
                                title: '<span class="text-success">成功</span>',
                                message:'更新成功',
                                callback: function () {
                                    allActivityController.reset();
                                    notStartActivityController.leave();
                                    runningActivityController.leave();
                                    endActivityController.leave();
                                    editActivityController.leave();
                                    addActivityController.leave();
                                    detailActivityController.leave();
                                    $('.create-groupon-activity').show();
                                }
                            });
                            self.stage.find('.submit').removeAttr('disabled');
                            self.stage.find('.submit').text('保存');
                        }else if(json.code == 401){
                            location.pathname = '/login';
                        }else{
                            bootbox.alert({
                                title: '<span class="text-danger">错误</span>',
                                message: json.error,
                            });
                            self.stage.find('.submit').removeAttr('disabled');
                            self.stage.find('.submit').text('保存');
                        }
                    }).fail(function (error) {
                        console.log(error);
                    });
                });
            },
            leave:function () {
                this.stage.find('input').val('');
                this.stage.find('.goods-image-box').show();
                this.stage.find('.img-box img').hide();
                this.stage.find('.groupon-product-price-box').html('');
                this.show = false;
                this.goods = null;
                this.leaderPreferOpen = false;
                this.stage.find('input[name="leader_prefer"]').removeAttr('checked');
                this.stage.find('input[name="auto_patch"]').attr('checked',true);
                this.limitSelected = true;
                this.stage.find('.submit').removeAttr('disabled');
                this.stage.find('.submit').text('保存');
                //$('.nav-tabs li[data-status="all"]').removeClass('active');
                $('.tab-content .tab-pane#edit').removeClass('active');
            },
            reset:function (id) {
                var self = this;
                this.id = id;
                this.show = true;
                HttpUtils.get('/ajax/shop/activity/groupon/'+id).done(function(res){
                    if(res.code == 200 && res.success && !!res.data){
                        self.data['start_time'] = res.data['start_time']*1000;
                        self.data['end_time'] = res.data['end_time']*1000;
                        self.data['start_format_time'] = res.data['start_format_time'];
                        self.data['start_format_time'] = res.data['end_format_time'];
                        self.status = res.data['status'];
                        self.autoPatch = res.data['auto_patch'];
                        self.leaderPreferOpen = res.data['leader_prefer'];
                        self.dataRender(res.data);
                        var goods = self.goods = res.data['goods'];
                        goods['sell_price'] = goods['sell_price'] / 100;
                        goods['market_price'] = goods['market_price'] / 100;
                        goods['price'] = goods['price'] / 100;
                        goods['leader_price'] = goods['leader_price'] / 100;

                        goods['sell_price'] = goods['sell_price'].toFixed(2);
                        goods['market_price'] = goods['market_price'].toFixed(2);
                        goods['price'] = goods['price'].toFixed(2);
                        goods['leader_price'] = goods['leader_price'].toFixed(2);
                        $.each(goods['products'] , function (index, product) {
                            product['sell_price'] = product['sell_price'] / 100;
                            product['market_price'] = product['market_price'] / 100;
                            product['price'] = product['price'] / 100;
                            product['leader_price'] = product['leader_price'] / 100;

                            product['sell_price'] = product['sell_price'].toFixed(2);
                            product['market_price'] = product['market_price'].toFixed(2);
                            product['price'] = product['price'].toFixed(2);
                            product['leader_price'] = product['leader_price'].toFixed(2);

                        });
                        self.stage.find('.groupon-product-price-box').html(goodsTable(self.goods, self.leaderPreferOpen));
                        self.notStart();
                        self.running();
                    }
                }).fail(function(){

                });
            }
        };
        editActivityController.init();
    });
</script>
@endpush