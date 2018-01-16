<style>
    .goods{
        width: 64px;
        height: 64px;
        border: 1px solid #e0e0e0;
    }
</style>
<div id = "detail_activity_page" class = "row" style = "margin-bottom: 36px;">
    <h2 class = "opt-title">拼团活动详情</h2>
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
                    <input type="text" class="form-control " name="activity_name" value="" placeholder="团购活动名称" readonly = "readonly"/>
                </div>
            </div>
            <div class="form-group activity-date" >
                <label class="col-sm-2 control-label required" for="platform_title">有效时间：</label>
                <div class = "col-sm-5">
                    <div  style="display: flex;width: 100%;">
                        <div style="width: 45%;">
                            <input readonly = "readonly"type="datetime" class="form-control datepicker start-datepicker" name="start_time" placeholder="团购活动开始时间" required>
                        </div>
                        <div style="width: 10%;height: 100%;text-align: center;vertical-align: middle;margin-top: 6px;">至</div>
                        <div style="width: 45%;">
                            <input readonly = "readonly" type="datetime" class="form-control datepicker end-datepicker" name="end_time" placeholder="团购活动结束时间" required>
                        </div>
                    </div>
                    <span class = "tips">开始时间必须大于当前时间，结束时间不得小于开始时间。</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label required" for="platform_title">参团人数：</label>
                <div class="col-sm-5 ">
                    <input readonly = "readonly" type="number" min ='2' max="100" step = "1" class="form-control " name="member_num" value="" placeholder="参加团购的人数" required/>
                    <span class = "tips">请填写2-100之间的数字哦</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label " for="platform_title">商品限制：</label>
                <div class="col-sm-5" style="display: flex;">
                    <label class="control-label" for="platform_title"> <input class ="buy-limit-num-checkbox" type="checkbox" disabled = "disabled">开启限购</label>
                    <label class = "label-buy-limit" style="display: flex;">
                        <input readonly = "readonly" type="number" min = "0" step="1" class="form-control " style="
                            padding: 0px 10px;
                            width: 72px;
                            margin-left: 8px;
                            height: 28px;
                            " name="buy_limit_num" value="1" placeholder="" required/>
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
                    <label class="control-label" for="platform_title"> <input name = "auto_patch" type="checkbox" disabled = "disabled">开启凑团</label>
                    <br>
                    <span class = "tips">开启凑团后，对于未参团的买家，活动商品详情页会显示未成团的团列表，买家可以直接任选一个参团，提升成团率。</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="platform_title">团长优惠：</label>
                <div class="col-sm-5" >
                    <label class="control-label" for="platform_title"> <input name = "leader_prefer" class = "leader-prefer-checkbox" type="checkbox" disabled = "disabled">团长享受优惠价</label>
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
        </form>
    </div>
</div>

@push('js')
<script>
    $(document).ready(function () {
        detailActivityController = {
            stage:$('#detail_activity_page'),
            leaderPreferOpen:false,
            limitSelected:true,
            data:{},
            show:false,
            leave:function () {
                this.stage.find('input').val('');
                this.stage.find('.img-box img').hide();
                this.show = false;
                this.goods = null;
                this.leaderPreferOpen = false;
                this.limitSelected = true;
                $('.tab-content .tab-pane#detail').removeClass('active');
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
                    this.stage.find('.label-buy-limit').show();
                    this.stage.find('input.buy-limit-num-checkbox').prop("checked", true);
                }else{
                    this.stage.find('.label-buy-limit').hide();
                    this.stage.find('input.buy-limit-num-checkbox').prop("checked", false);
                }

                this.stage.find('input[name="start_time"]').val(data['start_format_time']);
                this.stage.find('input[name="end_time"]').val(data['end_format_time']);
                this.stage.find('input[name="buy_limit_num"]').val(data['buy_limit_num']);
                this.stage.find('input[name="member_num"]').val(data['member_num']);

                this.stage.find('.img-box img').attr('src',data['goods']['image_url']);
                this.stage.find('.img-box img').show();
            },
            startTime:function (event, datepicker) {
            },
            endTime:function (event, datepicker) {
            },
            init:function () {
                dateTimeInit(this);
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
                        self.data['auto_patch'] = res.data['auto_patch'];
                        self.status = res.data['status'];
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
                        self.stage.find('.groupon-product-price-box input').attr('disabled','disabled');
                    }
                }).fail(function(){

                });
            }
        };
        detailActivityController.init();
    });
</script>
@endpush