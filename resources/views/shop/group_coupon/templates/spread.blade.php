@push('js')
<script type="text/template" id="groupon-act-spread">
    <!-- /*查看某商品独立佣金详情 */ -->
    <div class="form-group" style="height:320px;">
        <div class="col-sm-2" style="padding-top: 120px;"> 小程序码</div>
        <div class="col-sm-10" >
            <div style="margin-left: 80px;">微信“扫一扫”小程序访问</div>

            <img src="" id="mini_code" width="300px;"/>
            <div style="margin-left: 100px;margin-bottom: 10px;margin-top: -10px;"><a href="" id="weapp_code_download_saleout">下载小程序码</a></div>
        </div>

    </div>
    <div class="col-sm-2">
        小程序路径
    </div>
    <div class="col-sm-10 input-group form-group" style="line-height:21px;">
        <input type="text"
               class="form-control"
               name="path" id="path" disabled><span id="copy_word" style="font-size:12px; color:#ab9a9a;" class="input-group-addon">复制</span>
    </div>

    <script type="text/javascript">
        $('#mini_code').attr('src',res.mini_code);
        $('#path').val(res.path);
        $('#copy_word').click(function(){
            $(this).zclip({
                path: "{{asset('js/zclip/ZeroClipboard.swf')}}",
                copy: function(){
                    return res.path;
                },
                beforeCopy:function(){/* 按住鼠标时的操作 */
                    $(this).css("color","orange");
                },
                afterCopy:function(){/* 复制成功后的操作 */
                    $(this).css("color","green");
                    $(this).text('复制成功');
                }
            });

        });
        $('#weapp_code_download_saleout').click(function(){
            $(this).attr('href', '/ajax/shop/groupon-activity/downloadImage?mini_code=' + res.mini_code + '&type=goods&id=' + goodsId);
        });

</script>
</script>
@endpush