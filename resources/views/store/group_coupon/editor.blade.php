<style>
    .merchandise{
        width: 64px;
        height: 64px;
        border: 1px solid #e0e0e0;
    }
    .group-coupon-edit{
        margin-bottom: 36px;
    }
    .group-coupon-merchandise-add-btn{
        height: 100%;
    }
    .merchandise>.group-coupon-merchandise-add-btn>div{
        position: relative;
        top:50%;
        left: 50%;
        margin-top: -9px;
        margin-left: -9px;
    }
    .merchandise>.group-coupon-merchandise-add-btn>div>i{
        font-size: 18px;
        color: #00af12;
    }
    .merchandise .merchandise-image-box{
        width: 100%;
        height: 100%;
    }
    .merchandise .merchandise-image-box>i{
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
    }
    .merchandise .merchandise-image-box>img{
        width: 100%;
        height: 100%;
    }
    .group-coupon-form .group-coupon-date{
        display: flex;width: 100%;
    }
    .group-coupon-form .group-coupon-date .date-start,
    .group-coupon-form .group-coupon-date .date-end{
        width: 45%;
        position: relative;
    }
    .group-coupon-form .group-coupon-date .date-gap{
        width: 10%;
        height: 100%;
        text-align: center;
        vertical-align: middle;
        margin-top: 6px;
    }
    .group-coupon-limit-group .col-sm-5, .group-coupon-limit-group .buy-limit-label{
        display: flex;
    }
    .required:before {
        content: '*';
        font-size: 14px;
        color: #e01212;
    }

    .group-coupon-limit-group .buy-limit-num{
        padding: 0px 10px;
        width: 72px;
        margin-left: 8px;
        height: 28px;
    }
    .group-coupon-limit-group .buy-limit-unit{
        padding-top: 5px;
        padding-left: 8px;
        margin-bottom: 0;
    }
    .hidden{
        display: none;
    }
    .v-hidden {
        width: 0;
        height: 0;
        padding: 0;
        margin: 0;
        border: 0;
    }
    .form-group.has-error .merchandise {
        color: #dd4b39;
        border-color: #dd4b39;
    }
</style>
<div id = "group-coupon-edit" class = "row">
    <div class="form-box pull-right col-md-10">
        <form role = "form" data-toggle="validator" class="form-horizontal group-coupon-form" onsubmit="return false;" >
            <div class="form-group select-merchandise-group-coupon" >
                <label class="col-sm-2 control-label required" for="platform_title">选择商品：</label>
                <div class="col-sm-5 ">
                    <input class="form-control v-hidden merchandise-id" type = "text" data-bind-model = "merchandise_id"
                           name="merchandise_id" value="{{$groupCoupon && $groupCoupon->merchandise ? $groupCoupon->merchandise->id : ''}}"  required/>
                    <input class="form-control v-hidden merchandise-code" type = "text" data-bind-model = "merchandise_code"
                           name="merchandise_code" value="{{$groupCoupon && $groupCoupon->merchandise ? $groupCoupon->merchandise->code : ''}}"  required/>
                    <div class="merchandise">
                        <div class = "group-coupon-merchandise-add-btn {{$groupCoupon && $groupCoupon->merchandise ? 'hidden' : ''}}">
                            <div  >
                                <i class="fa fa-plus-circle"  aria-hidden="true"></i>
                            </div>
                        </div>
                        <div class = "img-box merchandise-image-box {{$groupCoupon && $groupCoupon->merchandise ? '' : 'hidden'}}">
                            <i class="fa fa-close" aria-hidden="true" ></i>
                            <img  src="{{$groupCoupon && $groupCoupon->merchandise ? $groupCoupon->merchandise->main_image_url : ''}}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group group-coupon-name-group">
                <label class="col-sm-2 control-label required" for="platform_title">活动名称：</label>
                <div class="col-sm-5 ">
                    <input type="text" class="form-control group-coupon-name" data-bind-model = "name" name="name"
                           value="{{$groupCoupon ? $groupCoupon->name : ''}}" placeholder="团购活动名称" required/>
                </div>
            </div>
            <div class="form-group date-time-group" >
                <label class="col-sm-2 control-label required" for="platform_title">有效时间：</label>
                <div class = "col-sm-5">
                    <div  class = "group-coupon-date">
                        <div class = "date-start">
                            <input type="datetime" class="form-control  start-date-picker" data-bind-model = "start_time" name="start_time"
                                   value="{{$groupCoupon ? date('Y-m-d h:i:s', $groupCoupon->start_time) : date('Y-m-d h:i:s')}}"  placeholder="团购活动开始时间" required>
                        </div>
                        <div class = "date-gap">至</div>
                        <div class="date-end">
                            <input type="datetime"  class="form-control end-date-picker" data-bind-model = "end_time" name="end_time"
                                   value="{{$groupCoupon ? date('Y-m-d h:i:s', $groupCoupon->end_time) : date('Y-m-d h:i:s', strtotime("+7 days"))}}"  placeholder="团购活动结束时间" required>
                        </div>
                    </div>
                    <span class = "tips text-warning">开始时间必须大于当前时间，结束时间不得小于开始时间。</span>
                </div>
            </div>
            <div class="form-group group-coupon-member-group">
                <label class="col-sm-2 control-label required" for="platform_title">参团人数：</label>
                <div class="col-sm-5 ">
                    <input type="number" min ='2' max="100" step = "1" class="form-control " data-bind-model = "member_num" name="member_num"
                           value="{{$groupCoupon ? $groupCoupon->member_num : ''}}"  placeholder="参加团购的人数" required/>
                    <span class = "tips text-warning">请填写2-100之间的数字哦</span>
                </div>
            </div>
            <div class="form-group group-coupon-limit-group">
                <label class="col-sm-2 control-label " for="platform_title">商品限制：</label>
                <div class="col-sm-5">
                    <label class="control-label" for="platform_title">
                        <input class ="buy-limit-num-checkbox" type="checkbox" {{$groupCoupon && $groupCoupon->buy_limit_num > 0 ? "checked" : ""}}>开启限购
                    </label>
                    <label class = "buy-limit-label {{$groupCoupon && $groupCoupon->buy_limit_num > 0 ? "" : "hidden"}}" >
                        <input type="number" min = "0" step="1" class="form-control buy-limit-num" data-bind-model = "buy_limit_num" name="buy_limit_num"
                              value = "{{$groupCoupon ? $groupCoupon->buy_limit_num : "1"}}" placeholder="" />
                        <label class = "buy-limit-unit">个／人</label>
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="platform_title">凑团设置：</label>
                <div class="col-sm-5" >
                    <label class="control-label" for="platform_title">
                        <input class = "auto-patch-checkbox" data-bind-model = "auto_patch" name = "auto_patch" type="checkbox"
                                {{!$groupCoupon || $groupCoupon->auto_patch == 1 ? "checked" : ""}}>开启凑团
                    </label>
                    <br>
                    <span class = "tips text-warning">
                        开启凑团后，对于未参团的买家，活动商品详情页会显示未成团的团列表，买家可以直接任选一个参团，提升成团率。
                    </span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="platform_title">团长优惠：</label>
                <div class="col-sm-5" >
                    <label class="control-label" for="platform_title">
                        <input name = "leader_prefer" data-bind-model = "leader_prefer" class = "leader-prefer-checkbox" type="checkbox"
                                {{$groupCoupon && $groupCoupon->leader_prefer == 1 ? "checked" : ""}}>团长享受优惠价
                    </label>
                    <br>
                    <span class = "tips text-warning">开启团长(开团人)优惠后，团长将享受更优惠价格，有助于提高开团率和成团率。</span>
                </div>
            </div>
            <div class="form-group group-coupon-price-group {{$groupCoupon ? '' : 'hidden'}}" >
                <label class="col-sm-2 control-label price-label-title required" for="platform_title">优惠设置：</label>
                <div class="col-sm-10 group-coupon-product-price-box">

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
@include('store.group_coupon.merchandiseList')
<script type="application/javascript">

    window.pageInit = function () {
        let Services = {
            saveGroupCoupon : function (data) {
                return $.post('/ajax/group/coupon/save', data);
            },
            updateGroupCoupon : function (id, data) {
                return $.ajax({
                    url: `/ajax/group/coupon/${id}`,
                    type: 'PUT',
                    data: data
                });
            },
            getGroupCouponInfo : function (id) {
                return $.get(`/ajax/group/coupon/${id}`);
            }
        };
        let GroupCouponController = function (id) {
            let merchandiseListController = new MerchandiseListController();
            let self = this;
            if( id != undefined && id ){
                self.refreshProductGroupPrice(self.productsTable(self.$data.products, self.$data.merchandise, self.$data.leader_prefer));
            }else{
                merchandiseListController.bindEvents('selectedMerchandise', function (data) {
                    self.$data['merchandise'] = data;
                    $('.merchandise-image-box img').attr('src', data.main_image_url);
                    $('.merchandise-image-box').removeClass('hidden');
                    $('.group-coupon-merchandise-add-btn').addClass('hidden');
                    $('.group-coupon-price-group').removeClass('hidden');
                    $('.group-coupon-name').val(data.name);
                    self.$data['name'] = data.name;
                    $('.merchandise-id').val(data.id);
                    $('.merchandise-code').val(data.code);
                    $('.select-merchandise-group-coupon').removeClass('has-error').removeClass('has-danger');
                    self.refreshProductGroupPrice(self.productsTable(data.products, data, self.$data.leader_prefer));
                });
                this.popupMerchandise(merchandiseListController);
            }
            this.bindEvents();
        };
        GroupCouponController.prototype = {
            $data: {
                id : '{{$id}}',
                leader_prefer : {!! $groupCoupon ? $groupCoupon->leader_prefer : 0 !!},
                buy_limit: {!! $groupCoupon && $groupCoupon->buy_limit_num > 0 ? 1 : 0 !!},
                price : {!! $groupCoupon ? $groupCoupon->price : 0 !!},
                min_price : {!! $groupCoupon ? $groupCoupon->min_price : 0 !!},
                max_price : {!! $groupCoupon ? $groupCoupon->max_price : 0 !!},
                leader_price : {!! $groupCoupon ? $groupCoupon->min_leader_price : 0 !!},
                min_leader_price : {!! $groupCoupon ? $groupCoupon->min_leader_price : 0 !!},
                max_leader_price : {!! $groupCoupon ? $groupCoupon->max_leader_price : 0 !!},
                merchandise: {!! $merchandise !!},
                products: {!! $products !!},
                start_time: {{$groupCoupon ? $groupCoupon->start_time : time()}},
                end_time: {{$groupCoupon ? $groupCoupon->end_time : strtotime('+7 days')}},
                name: '{{$groupCoupon['name']}}',
                member_num: {!! $groupCoupon ? $groupCoupon->member_num : 1 !!},
                buy_limit_num : {!! $groupCoupon ? $groupCoupon->buy_limit_num : 0 !!},
                auto_patch : {!! $groupCoupon ? $groupCoupon->auto_patch : 0 !!},
            },
            refreshProductGroupPrice: function (table) {
              $('.group-coupon-product-price-box').html(table);
            },
            init : function (groupCoupon) {
                //图片
                $('.merchandise-image-box img').attr('src', groupCoupon.merchandise.main_image_url);
            },
            setProducts : function (products) {

            },
            bindEvents : function () {
                let self = this;
                $('.merchandise-image-box').mouseover(function (event) {
                    $('.merchandise-image-box>i').show();
                }).mouseout(function (event) {
                    $('.merchandise-image-box>i').hide();
                }).on('click', '.fa-close', function(event){
                    self.$data['merchandise'] = null;
                    $('.merchandise-image-box img').attr('src', null);
                    $('.merchandise-image-box').addClass('hidden');
                    $('.group-coupon-merchandise-add-btn').removeClass('hidden');
                    self.refreshProductGroupPrice('');
                });
                $('.leader-prefer-checkbox').on('click', function (event) {
                    self.$data['leader_prefer'] = !self.$data['leader_prefer'];
                    if(self.$data['merchandise'] != undefined) {
                        self.refreshProductGroupPrice(self.productsTable(self.$data['merchandise']['products'], self.$data['merchandise'], self.$data['leader_prefer']));
                    }
                });
                let $startOptions = {
                    format: 'YYYY-MM-DD HH:mm:ss',
                    locale: '{{config('app.locale')}}',
                    minDate: '{{$groupCoupon ? date('Y-m-d h:i:s', $groupCoupon->start_time) : date('Y-m-d h:i:s')}}'
                };
                $('.start-date-picker').datetimepicker($startOptions).on("dp.change", function (e) {
                    $('.end-date-picker').data("DateTimePicker").minDate(e.date);
                    self.$data['start_time'] = e.date._d.getTime() / 1000;
                });
                let $endOptions = {
                    format: 'YYYY-MM-DD HH:mm:ss',
                    locale: '{{config('app.locale')}}',
                    minDate: '{{date('Y-m-d h:i:s', $groupCoupon ? $groupCoupon->end_time : strtotime('+7 days'))}}'
                };
                $('.end-date-picker').datetimepicker($endOptions).on("dp.change", function (e) {
                    $('.start-date-picker').data("DateTimePicker").maxDate(e.date);
                    self.$data['end_time'] = e.date._d.getTime() / 1000;
                });
                $('.buy-limit-num-checkbox').click(function (event) {
                    self.$data['buy_limit'] = !self.$data['buy_limit'];
                    if(self.$data['buy_limit']){
                       self.$data['buy_limit_num'] =  $('.buy-limit-num').attr('required', true).val();
                    }else{
                       $('.buy-limit-num').removeAttr('required');
                       self.$data['buy_limit_num'] =  0;
                    }
                });

                $('.group-coupon-form').validator().unbind('submit').bind('submit', function (e) {
                     self.validateGroupPrice();
                     if($(this).children('.has-error.has-danger').length){
                         return ;
                     }
                     self.submit();
                });
                self.watch();
            },
            popupMerchandise : function (merchandiseListController) {
                $('.group-coupon-merchandise-add-btn').unbind('click').bind('click', function (event) {
                    merchandiseListController.open();
                });
            },
            validateGroupPrice : function () {
                let self = this;
                if(self.$data['price'] == undefined){
                    $('.group-coupon-price-group').addClass('has-error has-danger');
                }else if(self.$data['leader_prefer'] && self.$data['leader_price'] == undefined){
                    $('.group-coupon-price-group').addClass('has-error has-danger');
                } else{
                    $('.group-coupon-price-group').removeClass('has-error has-danger');
                }                                                                                     
            },
            submit : function () {
                let inputs = $('form').serializeArray();
                let data = {};
                $.each(inputs, function (i, input) {
                    if(input.name.match('products_array'))
                        data[input.name] = input.value;
                });

                let tmp = {
                    'merchandise_id' : this.$data['merchandise']['id'],
                    'merchandise_code': this.$data['merchandise']['code'],
                    'store_id'  : this.$data['merchandise']['store_id'],
                    'store_code': this.$data['merchandise']['store_code'],
                    'name' : this.$data['name'],
                    'start_time' : this.$data['start_time'],
                    'end_time' : this.$data['end_time'],
                    'member_num' : this.$data['member_num'],
                    'buy_limit_num' : this.$data['buy_limit_num'],
                    'auto_patch' : this.$data['auto_patch'],
                    'leader_prefer' : this.$data['leader_prefer'],
                    'price' : this.$data['price'],
                };
                data = $.extend(tmp, data);
                let response = this.$data['id'] ? Services.updateGroupCoupon(this.$data['id'], data) :
                    Services.saveGroupCoupon(data);
                response.then(function (res) {
                    if(res.success){
                        bootbox.alert('团购创建或者更新成功', function () {
                            window.location.href = "/group/coupons"
                        })
                    }else{
                        bootbox.alert(res.error);
                    }
                });
            },
            watch : function () {
                let self = this;
                $('form').on('input propertychange', 'input', function () {
                    let key = $(this).data('bind-model'), value = $(this).val();
                    if(key != undefined)
                        self.$data[key] = value;

                    let name = $(this).data('name');
                    if(name == 'price'){
                        self.$data['price'] = parseFloat(value);
                    }else if(name == 'leader_price'){
                        self.$data['leader_price'] = parseFloat(value);
                    }
                });
            },
            productsTable : function(products, merchandise, leaderPrefer) {
                let table  = '<table class="table table-bordered">';
                let self = this;
                table += '<thead><tr>';
                if(products && products.length > 0){
                    table +=  '<th class = "sku">产品规格</th>';
                }
                table +=  '<th class = "origin-price" >产品原价（元）</th>';
                table += '<th class = "group-price" >团购价（元）</th>';
                table += '<th class = "leader-price" '+(leaderPrefer ? '' : 'hidden="true"')+'>团长优惠价（元）</th>';
                table += '<th class = "stock-num" >库存</th>';
                table += '</thead></tr>';
                table += '<tbody>';
                if(products  && products.length > 0){
                    $.each(products, function (index, product) {
                        table += self.productTr(product, leaderPrefer, index);
                    });
                }else{
                    table += self.merchandiseTr(merchandise, leaderPrefer);
                }
                table += '</tbody>';
                table +=  '</table>';
                return table;
            },
             productTr : function(product, leaderPrefer, index) {
                if(typeof  product['price'] == 'undefined'){
                    product['price'] = '';
                }
                if(typeof  product['leader_price'] == 'undefined'){
                    product['leader_price'] = '';
                }
                let td =
                    `<td class = "leader-price">
                        <input type = "number" name = "products_array[${index}][leader_price]" data-bind-model = "products_array[${index}][leader_price]" class = "form-control
                        leader-price-input products-leader-price-${product['id']}" data-name = "leader_price" data-type = "products"
                        data-index="${index}" data-id ="${product['id']}" value = "${product['leader_price']}" min ="0.01" step="0.01"
                        max="${product['sell_price']}" required>
                     </td>`;
                let tr =
                    `<tr>
                        <td class = "sku">${ product['sku'] }</td>
                        <td class = "origin-price">${ product['sell_price'] }</td>
                        <td class = "groupon-price">
                            <input type="hidden" data-bind-model = "products_array[${index}][id]" name = "products_array[${index}][id]" value="${product['id']}" hidden/>
                            <input type="number" data-bind-model = "products_array[${index}][price]" name = "products_array[${index}][price]"  class = "form-control  group-price-input
                            products-price-${product['id']}" data-name = "price" data-type = "products" data-index="${index}" data-id ="${product['id']}"
                            value = "${product['price']}"  min ="0.01" step="0.01" max="${product['sell_price']}" required>
                        </td>
                        ${leaderPrefer ? td : ''}
                        <td class = "stock-num">${product['stock_num']}</td>
                    </tr>`;
                return tr;
            },
            merchandiseTr: function(merchandise, leaderPrefer) {
                if(typeof  merchandise['price'] == 'undefined'){
                    merchandise['price'] = '';
                }
                if(typeof  merchandise['leader_price'] == 'undefined'){
                    merchandise['leader_price'] = '';
                }
                let leaderTd =
                    `<td class = "leader-price" >
                        <input type = "number" class = "form-control  leader-price-input merchandise-leader-pirce-${merchandise['id']}"
                         data-name = "leader_price" data-type = "merchandise"  data-id ="${merchandise['id']}"  value = "${merchandise['leader_price']}"
                          min ="0.01" step="0.01" max="${merchandise['sell_price']}" data-bind-model = "leader_price" required>
                     </td>`;
                return `<tr>
                            <td class = "origin-price">
                                ${merchandise['sell_price']}
                            </td>
                            <td class = "group-price">
                                <input type = "number" class = "form-control  group-coupon-price-input merchandise-price-${ merchandise['id']}"
                                data-name = "price" data-type = "merchandise" data-id ="${ merchandise['id']}"  value = "${merchandise['price']}"
                                min ="0.01" step="0.01" max="${merchandise['sell_price']}" data-bind-model = "price" required>
                            </td>
                            ${leaderPrefer ? leaderTd : ''}
                            <td class = "stock-num">
                                 ${merchandise['stock_num']}
                             </td>
                         </tr>`;
            }
        };
        let edit = new GroupCouponController({!! $id !!});
    };
</script>