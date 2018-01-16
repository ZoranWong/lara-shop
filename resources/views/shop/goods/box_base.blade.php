@extends('layouts.my_page')
@section('content')
<style>
.box-header{padding-bottom:0px;padding-top: 0px}
.box-header div{float:left;width:80px;height:50px;text-align: center;line-height: 50px}
.status-bottom{border-bottom: 2px solid #337AB7}
.status-left{border-left: 2px solid #337AB7}
.goods-status{cursor:pointer; padding-left:5px;}
.box-body-left{width:93px;float:left;background: #fff;position: relative}
.box-body-left div{height:50px;width:100%;line-height: 50px;text-align: center}
.box-body-left div a{color:#444;font-size: 17px}
.box-body-right{width:88%;float:left;background: #fff;position: relative;border-left:2px solid #D2D6DE }

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
<div class="row">
    <div class="col-xs-12" >
        <div class="box">
            <div class="box-header with-border"><div>
            <h3 class="box-title" style="line-height: 50px">商品管理</h3>
        </div>
        <div style="width:5px;border-right:2px solid #D2D6DE"></div>
        <div class="goods-status">
            <h3 class="box-title" style="line-height: 50px">@yield('box-title')</h3>
        </div>
    </div>
    <div class="col-xs-12" style="background-color:#fff;padding-left: 0px">
        <div class="box-body-left">
            <div class="status-left"><a href="/shop/goods">商品管理</a></div>
            <div><a href="/shop/goods/category">商品分组</a></div>
        </div>
        <div class="box-body-right">
            <div class="box-body">
                @yield('box-body')
            </div>
        </div>
    </div>
</div>
 
@stop