@push('js')
<script>
    //http通讯工具对象
    var HttpUtils = {
        get:function (url,query) {
            return $.ajax(url,{
                method:'GET',
                data:query
            });
        },
        post:function (url,data) {
            return $.ajax(url,{
                method:'POST',
                data:data
            });
        },
        put:function (url,data) {
            return $.ajax(url,{
                method:'PUT',
                data:data
            });
        },
        patch:function (url,data) {
            return $.ajax(url,{
                method:'PATCH',
                data:data
            });
        },
        del:function (url) {
            return $.ajax(url,{
                method:'DELETE'
            });
        }
    };
</script>
@endpush