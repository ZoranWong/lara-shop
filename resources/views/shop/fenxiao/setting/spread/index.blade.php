@include('layouts.vue_base')
@include('vendor.ueditor.head')
    <form class="form-horizontal" id="spread_form" autocomplete="off">
    	<pre>推广计划用于给申请分销商的用户介绍说明推广方式、模式说明等.
主要展示于申请分销商时的界面中显示和供已成为分销商的用户在系统内部查阅
		</pre>
    	<fieldset>
        	<legend>申请成为分销商推广语</legend>
            <div class="form-group">
                <div class="col-sm-12">
                  <script id="container" name="description" type="text/plain" style="height:300px;"></script>
                </div>
            </div>
        </fieldset>
         <div class="form-group">
            <div class="col-sm-10 col-sm-offset-4">
                <button class="btn btn-primary" id="spread_submit" style="margin:5px 10px 5px 80px;">保存修改</button>
            </div>
        </div>
    </form>
@push('js')
<script type="text/javascript">
    $('#spread_submit').click(function (){
        $.ajax({
            type: "POST",
            url:'/ajax/shop/fenxiao/spread',
            data:$('#spread_form').serialize(),// 你的formid
            async: false,
            error: function(request) {
                alert("Connection error");
            },
            success: function(json) {
                if(json.code == 200){
                    bootbox.alert({
                        title: '<span class="text-success">成功</span>',
                        message: "更改成功",
                        callback: function () {
                            location.pathname = "/shop/fenxiao/setting";
                        }
                    });
                } else {
                    bootbox.alert({
                        title: '<span class="text-success">失败</span>',
                        message: json.error,
                        callback: function () {
                            location.pathname = "/shop/fenxiao/setting";
                        }
                        
                    });
                }
            }
        });
        return false;
    });
    $(document).ready(function () {
        $.getJSON('/ajax/shop/fenxiao/basicSet',function (json) {
            var data = json.data.description; 
            //加载富文本编辑器
            var ue = UE.getEditor('container',{autoHeightEnabled: false});
            ue.ready(function() {
                ue.execCommand('serverparam', '_token', '{{ csrf_token() }}');
                if(data) {
                    ue.setContent(data);
                } else {
                    ue.setContent('');
                }
            });
        });
    });
</script>
@endpush
