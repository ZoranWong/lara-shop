{{--@include('UEditor::head')--}}
<script>
    window.HOST = "{{$host}}";
</script>
<script type="text/javascript" src="/ueditor/dist/utf8-php/ueditor.config.js"></script>
<!-- 编辑器源码文件 -->
<script type="text/javascript" src="/ueditor/dist/utf8-php/ueditor.all.js"></script>
<script src="{!!asset($UeditorLangFile)!!}"></script>
<script>
    window.categories = {!! $categories ? $categories : []!!};
    window.stores = {!! $stores ? $stores : []!!};
    window.storeId = {!! $storeId ? $storeId : 0!!};
    window.merchandise = {!! $merchandise ? $merchandise : 0!!};
    if(!window.merchandise){
        window.merchandise = {
            store_id: null,
            status: 'ON_SHELVES',
            name: '',
            category_id: null,
            sell_price: 0,
            market_price: 0,
            post_fee: 0,
            stock_num: 0,
            images: [],
            products: [],
            brief_introduction: null,
            content: null
        };
    }
</script>
<div id = "app">
    <merchandise-editor method = "{{$method}}" url = "{{$url}}">

    </merchandise-editor>
</div>