@extends('layouts.store_base')
@section('nav_title')
    <ul class="nav navbar-nav">
        <li><a href="/store/add">创建店铺</a></li>
    </ul>
@stop
@section('box_right_button')
    <div class="text-right" style="margin: 10px;">
        <a href="/store">返回列表</a>
    </div>
@stop
@section('content')
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body pad">
                        <form class="form-horizontal" id="form" autocomplete="off">
                            {{--店铺名称--}}
                            <div class="form-group">
                                <label for="inputName" class="col-md-2 control-label">店铺名称</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="inputName"
                                           placeholder="店铺名称"
                                           name="name"
                                           required>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            {{--企业类别--}}
                            <div class="form-group">
                                <label for="inputCategory" class="col-md-2 control-label">企业类别</label>
                                <div class="col-md-6">
                                    <select class="form-control"
                                            name="company_category"
                                            id="inputCategory"
                                            required>
                                        <option value>请选择企业类别</option>
                                        <option value="生活/家具">生活/家具</option>
                                        <option value="票务/旅行">票务/旅行</option>
                                        <option value="图书/音乐">图书/音乐</option>
                                        <option value="教育/培训">教育/培训</option>
                                        <option value="娱乐/健身">娱乐/健身</option>
                                        <option value="线下零售">线下零售</option>
                                        <option value="淘宝/京东">淘宝/京东</option>
                                        <option value="政府/协会">政府/协会</option>
                                        <option value="收藏/拍卖">收藏/拍卖</option>
                                        <option value="医疗/健康">医疗/健康</option>
                                        <option value="房地产">房地产</option>
                                        <option value="餐饮">餐饮</option>
                                        <option value="金融">金融</option>
                                    </select>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            {{--联系地址--}}
                            <div class="form-group">
                                <label for="inputAddress" class="col-md-2 control-label">联系地址</label>
                                <div class="col-md-2">
                                    <select class="form-control" name="province" id="province" required></select>
                                </div>
                                <div class="col-md-2">
                                    <select class="form-control" name="city" id="city"></select>
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="col-md-2">
                                    <select class="form-control" name="county" id="county" required></select>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            {{--公司名称--}}
                            <div class="form-group">
                                <label for="inputCompanyName" class="col-md-2 control-label">公司名称</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="inputCompanyName"
                                           placeholder="请输入营业执照上的公司全名"
                                           name="company"
                                           required>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            {{--联系人微信--}}
                            <div class="form-group">
                                <label for="inputWechat" class="col-md-2 control-label">联系人微信</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="inputWechat"
                                           placeholder="联系人微信"
                                           name="contact_wx"
                                           required>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-8">
                                    <button class="btn btn-success center-block">创建</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

@stop
@section('js')
<script src="{{ asset('bower_components/city-select/LocalList.js') }}"></script>
<script>
$(document).ready(function () {
        LocalList.mf_init({
            country: 'province', //省级select ID
            state: 'city',     //市级select ID
            city: 'county',
            language: 'zh_cn',
            path_to_xml: '/bower_components/city-select/data/china/',
            read_only: false
        });

        $('#form').validator().on('submit', function (e) {
            if(!e.isDefaultPrevented()){
                e.preventDefault();
                var data = $(e.target).serializeArray();
                var newData = {};
                data.map(function (item) {
                    if(item['name'] == 'city'){
                        item['value'] = $('#city').find("option:selected").text();
                    }
                    if(item['name'] == 'province'){
                        item['value'] = $('#province').find("option:selected").text();
                    }
                    if(item['name'] == 'county'){
                        item['value'] = $('#county').find("option:selected").text();
                    }
                    newData[item['name']] = item['value'];
                });
                $.post('/ajax/store/create' , newData , function (json) {
                    if(json.code == 200 ){
                        bootbox.alert({
                            title: '<span class="text-success">成功</span>',
                            message:'新建店铺成功',
                            callback: function () {
                                location.pathname = '/store';
                            }
                        });
                    }else if(json.code == 401){
                        location.pathname = '/login';
                    }else{
                        bootbox.alert({
                            title: '<span class="text-danger">错误</span>',
                            message: json.error,
                        });
                    }
                }, 'json')
            }
        })
    })
</script>
@stop
