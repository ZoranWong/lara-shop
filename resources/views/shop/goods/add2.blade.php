@extends('layouts.box_base')
@include('layouts.vue_base')
@include('vendor.ueditor.head')
@section('box-title')
    新增商品
@stop
<style>
    .icon_thumb{margin-top:26px;width: 44px;height: 34px;vertical-align: middle;display: inline-block;line-height: 100px;overflow: hidden;background: url(/images/wechat_media.png) 0 -88px no-repeat;}
    .img-box{width: 100px;background-color: #ececec;font-size: 14px;height: 86px;text-align: center;cursor: pointer;}
    .img-wrap{float:left;margin-left:-12px;border: 1px solid #e0e0eb;padding: 5px;width: 110px;}

    .box-left{  border-radius: 3px; margin: 0 0 20px 0;  padding: 5px 3px 5px 15px; border: 1px solid #ddd; margin: 0 -15px 0 -26px; }
    .box-left a{ color:#000; }
    .image-errors{ color: red; display:none; }
    .gbin1-list {list-style: none;padding:0;margin:0;}

    .gbin1-list li {float: left;width: 100px;height: 100px;text-align: center;margin-right: 20px;border-radius: 5px;padding: 0px;}
    .gbin1-list li a{position :absolute;margin-left: 84px;;margin-top: -12px;font-size: 22px;border-radius: 50%;width: 26px;height: 26px;text-align: center;line-height: 26px;background:red;color:#fff;display: none;}
    .gbin1-list li img{width: 100px;height: 100px;}
    .form-required:after {
        content: "*";
        margin-right: 6px;
        color: #ff4949;
        font-size: 18px;
    }
</style>
@section('box-body')
    <div id="app">
        <div class="form-group" style="height:80px;">
            <div class="col-sm-12">
                <div class="col-sm-8 col-sm-offset-2">
                    <div style="width:50%;float:left;" id="top1">
                        <a href="javascript:void(0)" onclick="selectd(1)" class="btn btn-block btn-default btn-success btn-flat">编辑商品信息</a>
                    </div>
                    <div style="width:50%;float:left;" id="top2">
                        <a href="javascript:void(0)" onclick="selectd(2)" class="btn btn-block btn-default btn-flat">编辑商品详情</a>
                    </div>
                </div>
            </div>
        </div>
        <form class="form-horizontal" id="form1" autocomplete="off">
            <div class="form-group">
                <label class="col-sm-2 control-label">分组</label>
                <div class="col-sm-10">
                    <div class="form-group">
                        <label for="g-category" class="col-sm-2 control-label">
                            商品分组：
                        </label>
                        <div class="col-sm-4">
                            <select name="category_id" class="form-control" id="g-category">
                                
                            </select>
                        </div>
                        <div class="col-sm-4" style="padding-top: 7px;">
                            <a href="javascript:void(0)" onclick="getCategory()">刷新</a>
                            <span>  |  </span>
                            <a href="/shop/goods/category" target="_blank">新建分组</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">库存\规格</label>
                <div class="col-sm-10">
                    <sku></sku>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">商品信息</label>
                <div class="col-sm-10">
                    <div class="form-group">
                        <label for="g-name" class="col-sm-2 control-label">
                            <i class="form-required"></i>商品名：
                        </label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="g-name"
                                    placeholder="商品名称"
                                    autocomplete="off"
                                    name="name"
                                    required>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="g-prime_price" class="col-sm-2 control-label">
                            <i class="form-required"></i>价格：
                        </label>
                        <div class="col-sm-2">
                            <input type="number" class="form-control" id="g-prime_price"
                                    placeholder="元"
                                    autocomplete="off"
                                    min="0.00"
                                    step="0.01"
                                    required>
                        </div>
                        <label class="col-sm-1 control-label">原价</label>
                        <div class="col-sm-2">
                            <input type="number" class="form-control" id="g-market_price"
                                    placeholder="元"
                                    autocomplete="off"
                                    min="0.00"
                                    step="0.01"
                                    required>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label id="g-image" class="col-sm-2 control-label">
                            <i class="form-required"></i>商品图片：
                        </label>
                        <div class="col-sm-10">
                            <div class="col-sm-12">
                                <ul class="gbin1-list"></ul>

                                <div class="img-wrap">
                                    <a href="javascript:void(0)" onclick="uploads()">
                                        <div class="img-box" >
                                            <i class="icon_thumb"></i>
                                        </div>
                                    </a>
                                </div>

                            </div>
                            <div class="help-block with-errors">
                                <ul class="list-unstyled"><li>建议尺寸640*640，您可以拖拽图片调整图片顺序</li></ul>
                            </div>
                            <div class="help-block with-errors image-errors">
                                <ul class="list-unstyled"><li>请上传图片</li></ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">物流\其它</label>
                <div class="col-sm-10">
                    <div class="form-group">
                        <label for="g-post_fee" class="col-sm-2 control-label">
                            <i class="form-required"></i>运费：
                        </label>
                        <div class="col-sm-4">
                            <input type="number" class="form-control" id="g-post_fee"
                                    placeholder="元"
                                    autocomplete="off"
                                    min="0.00"
                                    step="0.01"
                                    required>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-4 col-sm-offset-3">
                    <a href="javascript:void(0)" onclick="nextFrom()" class="btn btn-primary form-control">下一页</a>
                </div>
            </div>
        </form>

        <form class="form-horizontal" id="form2" autocomplete="off" style="display:none;">
            <div class="form-group">
                <label class="col-sm-2 control-label">商品简介<br>（选填）：</label>
                <div class="col-sm-8">
                    <textarea type="text" class="form-control" 
                            id="briefIntroduction"
                            placeholder="商品简介 ..."
                            autocomplete="off"></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">商品详情</label>
                <div class="col-sm-8">
                    <script id="container" name="content" type="text/plain"></script>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-4 col-sm-offset-2">
                    <a class="btn btn-primary form-control" href="javascript:void(0)" onclick="submitFrom(this,1)">上架</a>
                </div>
                <div class="col-sm-4">
                    <a class="btn btn-default form-control"  href="javascript:void(0)" onclick="submitFrom(this,0)">下架</a>
                </div>
            </div>
        </form>
    </div>
@stop

@section('js')
<script type="text/javascript" src="https://cdn.bootcss.com/jquery-sortable/0.9.13/jquery-sortable-min.js"></script> 
  <script>
    function selectd(index) {
        if(index == 1){
            $("#form1").show();
            $("#form2").hide();
            $("#top1 a").addClass('btn-success');
            $("#top2 a").removeClass('btn-success');
            
        }else{
            $('#form1').submit();
        }
    }
    function uploads() {
        bootbox.dialog({
            title: '上传文件',
            message: '<div class="dropzone" id="myDrop"></div>'
        });
        var myDrop = new Dropzone('#myDrop',{
            url: "/upload/image_image",
            paramName: 'image',
            dictDefaultMessage: '点击上传文件<br />或将文件拖到这里',
            maxFiles: 1,
            addRemoveLinks: true,
            dictResponseError: '错误'
        });
        myDrop.on('success',function(file,info){
            imageList.push(info.data);
            imageHtml();

            $(".image-errors").hide();
            $("#g-image").css('color', '#636b6f');

            bootbox.hideAll();
        });
    }

    function bigImg(e) {     
        $(e).find('a').show();
    }
    function normalImg(e){
        $(e).find('a').hide();
    }
    
    function imageDelete(i) {            
        imageList.splice(i, 1);
        if(imageList.length<1){
            $(".image-errors").show();
            $("#g-image").css('color', 'red');
        }
        imageHtml();
    }
    var image = '';
    var imageList = [];
    function imageHtml() {
        var html = '';            
        imageList.forEach(function(element, i) {
            html += '<li onmouseover="bigImg(this)" onmouseout="normalImg(this)"><a href="javascript:void(0)" onclick="imageDelete('+i+')">X</a><img src="'+element+'" /></li>'
        }, this);

        $(".gbin1-list").html(html);
        $('.gbin1-list').sortable().bind('sortupdate');
    }
    imageHtml();

    function getCategory() {
        $.getJSON('/ajax/shop/category/list',function (json) {
            var data = json.data;
            var chtml = '<option value="">请选择商品类型</option>'
            if(data){
                data.forEach(function(element) {
                    chtml += '<option value="'+element.id+'">'+element.name+'</option>';
                }, this);
            }
            $("#g-category").html(chtml);
        })
    }
    function nextFrom() {
        if(imageList.length<1){
            $(".image-errors").show();
            $("#g-image").css('color', 'red');
        }
        $('#form1').submit();
    }
    var fromData = '';
    var status = 0;
    function submitFrom(e, i) {
        status = i;
        $(e).attr('disabled', 'disabled');
        $(e).text('提交中...');
        $('#form2').submit();
    }

    function serializeNotNull(serStr){
        return serStr.split("&").filter(function(str){return !str.endsWith("=")}).join("&");
    }
    $(document).ready(function () {
        //加载富文本编辑器
        var ue = UE.getEditor('container');
            ue.ready(function() {
            ue.execCommand('serverparam', '_token', '{{ csrf_token() }}');
        });

        //获取商品分类
        getCategory();

        // 表单验证提交
        $('#form1').validator().on('submit', function (e) {
            fromData = '';
            if(imageList.length<1){
                $(".image-errors").show();
                $("#g-image").css('color', 'red');
                return false;
            }
            if(!e.isDefaultPrevented()){
                e.preventDefault();
                fromData = $(e.target).serialize();

                if(imageList.length>0){
                    fromData += '&images='+imageList + '&image_url='+imageList[0];
                }
                var marketPrice = $("#g-prime_price").val();
                if(marketPrice){
                    fromData = fromData +'&prime_price='+ parseFloat(marketPrice)*100;
                }
                var postFee = $("#g-post_fee").val();
                if(postFee){
                    fromData = fromData +'&post_fee='+ parseFloat(postFee)*100;
                }
                
                var products = $('[name="products"]').val();
                if(products){
                    fromData += '&products='+products;
                }
                $("#form1").hide();
                $("#form2").show();
                $("#top2 a").addClass('btn-success');
                $("#top1 a").removeClass('btn-success');
            }
            return false;
        });

        $('#form2').validator().on('submit', function (e) {
            if(!e.isDefaultPrevented()){
                e.preventDefault();
                var data = fromData +'&status='+status+'&'+ $(e.target).serialize();
            
                data = serializeNotNull(data);
                $.post('/ajax/shop/goods/create' , data , function (json) {
                    if(json.success == true ){
                        if(json.data){
                            bootbox.alert({
                                title: '<span class="text-success">提示</span>',
                                message:'添加成功',
                                callback: function () {
                                    location.pathname = '/shop/goods';
                                }
                            });
                        }else{
                            bootbox.alert({
                                title: '<span class="text-success">提示</span>',
                                message:'添加失败',
                            });
                            $('#submit').removeAttr('disabled');
                            $('#submit').text('提交');
                        }
                    }else if(json.code == 401){
                        location.pathname = '/login';
                    }else{
                        bootbox.alert({
                            title: '<span class="text-danger">错误</span>',
                            message: json.error,
                        });
                        $('#submit').removeAttr('disabled');
                        $('#submit').text('提交');
                    }
                }, 'json')
            }
        });
    })
  </script>
@stop
