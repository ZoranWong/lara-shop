<div class="card card-default">
    <!-- Default panel contents -->
    <div class="card-header">店铺后台微信登录授权二维码</div>
    <div class="container-fluid">
        <div class="d-flex flex-row">
            <div class="">
                {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(131)->generate(Request::url()) !!}
            </div>
            <div class="pt-4 pr-5">
                <span>店主或者店铺管理员使用微信扫描后完成微信绑定</span>
            </div>
        </div>
    </div>
</div>