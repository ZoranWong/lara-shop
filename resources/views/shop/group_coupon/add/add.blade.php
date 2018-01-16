<style>
    .goods{
        width: 64px;
        height: 64px;
        border: 1px solid #e0e0e0;
    }
</style>
<div id = "add_activity_page" class = "row" style = "margin-bottom: 36px;">
    <h2 class = "opt-title">新建拼团活动</h2>
    <div class="form-box pull-right col-md-10">
        <form role = "form" class="form-horizontal add-groupon-activity" onsubmit="return false;" >
            <div class="form-group select-goods-group" >
                <label class="col-sm-2 control-label required" for="platform_title">选择商品：</label>
                <div class="col-sm-5 ">
                    <input type="hidden" class="form-control " type = "number" name="goods_id" value="" required/>
                    <div class="goods">
                        <div id = "activity_goods_add" style="height: 100%;">
                            <div style="position: relative;top:50%;left: 50%;margin-top: -9px;margin-left: -9px;" >
                                <i class="fa fa-plus-circle" style="font-size: 18px;color: #00af12;" aria-hidden="true"></i>
                            </div>
                        </div>
                        <div class = "img-box goods-image-box" style="display: none;width: 100%;height: 100%;">
                            <i class="fa fa-close" aria-hidden="true" style="
                                position: absolute;
                                top: -12px;
                                left: 70px;
                                border: 2px solid #d6d6d6;
                                background: #d6d6d6;
                                color: white;
                                border-radius: 100%;
                                width: 18px;
                                padding-left: 1px;
                                display:none;
                            "></i>
                            <img  style="width: 100%;height: 100%;" src="">
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
                    <input type="number" min ='2' max="100" step = "1" class="form-control " name="member_num" value="" placeholder="参加团购的人数" required/>
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
                    <label class="control-label" for="platform_title"> <input class = "auto-patch-checkbox" name = "auto_patch" type="checkbox" checked>开启凑团</label>
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
            <div class="form-group groupon-activity-price" style="display: none;">
                <label class="col-sm-2 control-label price-label-title required" for="platform_title">优惠设置：</label>
                <div class="col-sm-10 groupon-product-price-box">

                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-2 col-sm-offset-2">
                    <a class="btn  btn-default form-control cancel" href="javascript:void(0)" >取消</a>
                </div>
                <div class="col-sm-2">
                    <button class="btn btn-primary form-control submit">保存</button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('js')
<script>
    $(document).ready(function () {
        addActivityController = {
            stage:$('#add_activity_page'),
            leaderPreferOpen:false,
            limitSelected:false,
            autoPatch:true,
            events:{
            },
            data:{},
            selectGoods:function (goods) {
                goods['sell_price'] = goods['sell_price'] / 100;
                goods['market_price'] = goods['market_price'] / 100;

                goods['sell_price'] = goods['sell_price'].toFixed(2);
                goods['market_price'] = goods['market_price'].toFixed(2);

                $.each(goods['products'] , function (index, product) {
                    product['sell_price'] = product['sell_price'] / 100;
                    product['market_price'] = product['market_price'] / 100;

                    product['sell_price'] = product['sell_price'].toFixed(2);
                    product['market_price'] = product['market_price'].toFixed(2);
                });
                this.goods = goods;
                this.stage.find('.groupon-product-price-box').html(goodsTable(goods, this.leaderPreferOpen));
                this.stage.find('.groupon-activity-price').show();
                this.stage.find('input[name="goods_id"]').val(goods['id']);
                this.stage.find('input[name="activity_name"]').val(goods['name']);
                this.stage.find('.goods-image-box>img').attr('src',goods['image_url']);
                this.stage.find('.goods-image-box>img').show();
                this.stage.find('.goods-image-box').show();
                this.stage.find('#activity_goods_add').hide();

            },
            removeGoods:function () {
                this.goods = null;
                this.stage.find('.groupon-product-price-box').html('');
                this.stage.find('.groupon-activity-price').hide();
                this.stage.find('input[name="goods_id"]').val('');
                this.stage.find('input[name="activity_name"]').val('');
                this.stage.find('.goods-image-box>img').attr('src','');
                this.stage.find('.goods-image-box>img').hide();
                this.stage.find('.goods-image-box').hide();
                this.stage.find('#activity_goods_add').show();
            },
            showPrice:function ($originPrice,$stockNum) {
                this.stage.find('.groupon-activity-price').show();
                this.stage.find('.goods-origin-price').html($originPrice / 100);
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
                var minuteMS = 60 * 1000;
                this.data['start_time'] = parseInt(event.date.getTime() / minuteMS) * minuteMS;
                var error = this.data['start_time'] < Date.now() || (typeof this.data['end_time'] != 'undefined' &&
                    ( this.data['end_time'] < Date.now() || this.data['start_time'] > this.data['end_time']));
                if(error){
                    this.stage.find('.activity-date').addClass('has-error has-danger');
                }else{
                    this.stage.find('.activity-date').removeClass('has-error has-danger');
                    this.stage.find('input.start-datepicker').val(event.date.format('yyyy-MM-dd hh:mm')+":00");
                    //this.stage.find('input.start-datepicker').datetimepicker('update');
                }
            },
            endTime:function (event, datepicker) {
                var minuteMS = 60 * 1000;

                this.data['end_time'] =  parseInt(event.date.getTime() / minuteMS) * minuteMS;

                var error = this.data['end_time'] < Date.now() || (typeof this.data['start_time'] != 'undefined' &&
                    (this.data['start_time'] < Date.now() || this.data['start_time'] > this.data['end_time']));
                if(error){
                    this.stage.find('.activity-date').addClass('has-error has-danger');
                }else{
                    this.stage.find('.activity-date').removeClass('has-error has-danger');
                    this.stage.find('input.end-datepicker').val(event.date.format('yyyy-MM-dd hh:mm')+":00");
                }
            },
            init:function () {
                dateTimeInit(this);
                var self = this;
                this.stage.find('input').val('');
                this.stage.on('click','.leader-prefer-checkbox',function () {
                    if(!self.leaderPreferOpen){
                        self.showLeaderPrice();
                    }else{
                        self.hideLeaderPrice();
                    }
                });
                var limitNum = 1;
                this.stage.on('click','.auto-patch-checkbox',function () {
                    self.autoPatch = !self.autoPatch;
                });
                self.hideLimit();
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
                
                this.stage.on('click','#activity_goods_add',function (e) {
                    var text = $('#activity-goods-select-template').text();
                    //$('body').append(html);
                    bootbox.dialog({
                        'title':'',
                        'message': text,
                        buttons: {
                            Cancel: {
                                label: "关闭",
                                className: "btn-default",
                                callback: function () {
                                    console.log('关闭');
                                }
                            }
                        }
                    });
                });
                this.stage.find('.goods-image-box').mouseover(function () {
                    self.stage.find('.goods-image-box>i').show();
                });

                this.stage.find('.goods-image-box').mouseout(function () {
                    self.stage.find('.goods-image-box>i').hide();
                });

                this.stage.find('.goods-image-box>i.fa-close').click(function () {
                    self.removeGoods();
                    self.hidePrice();
                });

                $.each(this.events,function (index, value) {
                    var arr = index.split(' ');
                    self.stage.on(arr[0], arr[1], value);
                });


                this.stage.find('form').validator().on('submit', function (e) {
                    var data = $(e.target).serializeArray();
                    var canSubmit =true;
                    var temp = {};
                    $.each(data,function (index, value) {
                        if(value['name'] =='goods_id'){
                            if(value['value'] == ''){
                                self.stage.find('.select-goods-group').addClass('has-error has-danger');
                                canSubmit &=false;
                            }else{
                                self.stage.find('.select-goods-group').removeClass('has-error has-danger');
                                canSubmit &=true;
                            }
                        }
                        if(value['value'] != ''){
                            temp[value['name']] = value['value'];
                        }

                    });

                    var error = (typeof self.data['end_time'] == 'undefined' || typeof self.data['start_time'] == 'undefined' || ((self.data['start_time']
                        > self.data['end_time']) || self.data['start_time'] < Date.now() || self.data['end_time'] < Date.now()));
                    if(error){
                        self.stage.find('.activity-date').addClass('has-error has-danger');
                        canSubmit &=false;
                    }else{
                        self.stage.find('.activity-date').removeClass('has-error has-danger');
                        canSubmit &=true;
                    }

                    if(parseInt(temp['member_num']) >= 2 && parseInt(temp['member_num']) < 100){
                        canSubmit &=true;
                    }else{
                        canSubmit &=false;
                    }

//                    if(parseInt(temp['buy_limit_num']) >= 1){
//                        canSubmit &=true;
//                    }else{
//                        canSubmit &=false;
//                    }

                    function priceerror(data) {
                        if(typeof data['price'] != 'undefined'){
                            if(data['price'] == "" || data['sell_price'] == "" || parseFloat(data['price']) > parseFloat(data['sell_price']) || parseFloat(data['price']) <= 0){
                                return false;
                            }else{
                                if(typeof data['leader_price'] != 'undefined'){
                                    if ( data['price'] == "" || data['sell_price'] == "" ||  parseFloat(data['leader_price']) > parseFloat(data['price']) || self.leaderPreferOpen && parseFloat(data['leader_price']) <= 0){
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

                    if(!canSubmit){
                        return;
                    }

                    self.stage.find('.submit').attr('disabled', 'disabled');
                    self.stage.find('.submit').text('保存中...');

                    temp['auto_patch'] = self.autoPatch ? 1 : 0;
                    !self.leaderPreferOpen ? (delete temp['leader_prefer']) : (temp['leader_prefer'] = 1);
                    temp['start_time'] = self.data['start_time']/1000;
                    temp['end_time'] = self.data['end_time']/1000;

                    
                    HttpUtils.post('/ajax/shop/activity/groupon',temp).done(function(json){
                        if(json.code == 200 && json.success){
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

                this.stage.on('change', '.groupon-product-price-box input', function (e) {
                    var target = $(e.target);
                    if(target.data('type') == 'goods'){
                        self.goods[target.data('name')] = target.val();
                    }else{
                        self.goods['products'][target.data('index')][target.data('name')] = target.val();
                        console.log(self.goods['products'][target.data('index')]);
                    }
                });
            },
            leave:function () {
                this.stage.find('input').val('');
                this.stage.find('.goods-image-box').hide();
                this.stage.find('#activity_goods_add').show();
                this.stage.find('.goods-image-box>img').attr('src','');
                this.stage.find('.goods-image-box>img').hide();
                this.stage.find('.groupon-activity-price').hide();
                this.stage.find('.groupon-product-price-box').remove('table');
                this.goods = null;
                this.leaderPreferOpen = false;
                this.limitSelected = false;
                this.autPatch = true;
                this.stage.find('input[name="leader_prefer"]').prop("checked", false);
                this.stage.find('input[name="auto_patch"]').prop("checked", true);
                this.stage.find('.submit').removeAttr('disabled');
                this.stage.find('.submit').text('保存');
                $('.tab-content .tab-pane#add').removeClass('active');
                //this.show = false;
            },
            reset:function (data) {

            }
        };
        addActivityController.init();
    });
</script>
@endpush