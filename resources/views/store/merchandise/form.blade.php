@include('UEditor::head')
<script>
    window.UEDITOR_HOME_URL = "{{$host}}";
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