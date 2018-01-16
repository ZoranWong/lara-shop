
<div id="toolbar">
    <form class="form-horizontal" id="form">
        <div class="col-md-3">
            <div class="input-group col-md-12">
                <div class="input-group-addon">ID</div>
                <input type="text" class="form-control input" name="weapp_user_id" placeholder="ID" maxlength="60">
            </div>
        </div>
          <div class="col-md-3">
            <div class="input-group col-md-12">
                <div class="input-group-addon">姓名</div>
                <input type="text" class="form-control input" name="full_name" placeholder="分销商姓名搜索" maxlength="60">
            </div>
        </div>
        <div class="col-md-3">
            <div class="input-group col-md-12">
                <div class="input-group-addon">手机号</div>
                <input type="text" class="form-control input" name="mobile" placeholder="手机号" maxlength="11">
            </div>
        </div>
         <div class="col-md-3">
            <div class="input-group col-md-12">
                <div class="input-group-addon">推荐人</div>
                <input type="text" class="form-control input" name="father_nickname" placeholder="推荐人" maxlength="60">
            </div>
        </div>
        <div class="col-md-12" style="height: 15px;"></div>
        <div class="col-md-3">
            <div class="input-group col-md-12">
                <div class="input-group-addon">分销商等级</div>
                <select class="select form-control" name="level_id" id="level_name">
                    <option value="">请选择</option>
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="input-group col-md-12">
                <div class="input-group-addon">状态</div>
                <select class="select form-control" name="apply_status">
                    <option value="">请选择</option>
                    <option value="0">未申请</option>
                    <option value="1">待审核</option>
                    <option value="2">通过</option>
                    <option value="3">拒绝</option>
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="input-group col-md-12">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input type="text" name="join_time_start" class="form-control pull-right datetimepicker_list" placeholder="加入时间(开始)" readonly>

            </div>
        </div>
        <div class="col-md-3">
            <div class="input-group col-md-12">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input type="text" name="join_time_end" class="form-control pull-right datetimepicker_list" placeholder="加入时间(结束)" readonly>

            </div>
        </div>    
        
        <div class="col-md-12" style="margin-top:15px;"></div>
        <div class="col-md-5" style="float: right;">
            <button type="submit" class="btn btn-primary">搜索</button>
            <button type="reset" class="btn btn-info">重置</button>
            <button id="downloadToExecl" class="btn btn-default">导出Excel</button>
            <button type="button" id="copylink" class="btn btn-default">复制系统链接</button></div>
    </form>
</div>

<div class="box-body">
    <table id="table"
           data-toolbar="#toolbar"
           data-pagination="true"
           data-id-field="weapp_user_id"
           data-page-size="10"
           data-page-list="[10, 25, 50, 100]"
           data-show-footer="false"
           data-side-pagination="server"
           data-query-params="queryParams"
           data-url="/ajax/shop/fenxiao/member/list"
           data-response-handler="responseHandler">
    </table>
</div>
<style>
    .fixed-table-container {
        min-height:278px;
    }
</style>
<!-- /.box-body -->

@push('js')
<script type="text/javascript" src="{{ asset('js/zclip/jquery.zclip.js') }}"></script>
<script>

$(document).ready(function () {
    var total_rows_record = 0;
    var download_url_list = '';
    var $table = $('#table');
    function initTable() {
        $table.bootstrapTable({
            pagination: true,/*是否分页显示*/
            sidePagination: "server", /*分页方式：client客户端分页，server服务端分页*/
            smartDisplay: false,/*隐藏分页*/
            paginationPreText: "上一页",
            paginationNextText: "下一页",
            pageNumber: 1,
            pageSize: 10,
            striped: true,
            showColumns: true,//列选择按钮
            height: getHeight(),
            columns: [
                [
                    {
                        field: 'weapp_user_id',
                        title: 'ID',
                        align: 'center',
                        valign: 'middle',
                        sortable: true,
                    }, {
                        field: 'nickname',
                        title: '头像／昵称',
                        align: 'center',
                        valign: 'middle',
                        formatter: nicknameFormatter
                    }, {
                        field: 'levelName',
                        title: '用户等级',
                        align: 'center',
                        valign: 'middle'
                    }, {
                        valign: 'middle',
                        field: 'mobile',
                        title: '个人信息',
                        editable: true,
                        align: 'center',
                        formatter: informationFormatter
                    }, {
                        field: 'total_commission_wait',
                        title: '未结算佣金',
                        align: 'center',
                        valign: 'middle',
                        sortable: true,
                    }, {
                        field: 'total_commission_amount',
                        title: '已结算佣金',
                        align: 'center',
                        valign: 'middle',
                        sortable: true,
                    }, {
                        field: 'sales_amount',
                        valign: 'middle',
                        title: '销售额',
                        editable: true,
                        align: 'center',
                    }, {
                        field: 'father_nickname',
                        valign: 'middle',
                        title: '推荐人',
                        editable: true,
                        align: 'center',
                        formatter: fatherNicknameFormatter
                    }, {
                        field: 'lower',
                        title: '下线人数',
                        editable: true,
                        align: 'center',
                        valign: 'middle'
                    }, {
                        field: 'join_time',
                        title: '加入时间',
                        valign: 'middle',
                        align: 'center',
                        valign: 'middle',
                        formatter: joinFormatter
                    }, {
                        field: 'operate',
                        title: '操作',
                        align: 'center',
                        valign: 'middle',
                        events: operateEvents,
                        formatter: operateFormatter
                    }
                ]
            ],
            responseHandler: function (res) {
                total_rows_record = res.data.total;
                download_url_list = res.data.params;
                return res.data;

            },
            'queryParams': function(params){
                var arr = ['level_id','weapp_user_id','full_name','mobile','father_nickname','join_time_start','join_time_end','apply_status','lower'];
                arr.forEach(function(item){
                    if($('#form [name='+item+']').val() == '' || typeof($('#form [name='+item+']').val()) == 'undefined' ){
                    } else {
                        params[item] = $('#form [name='+item+']').val();
                    }
                });
                return params;
            }
        });

        setTimeout(function () {
            $table.bootstrapTable('resetView');
        }, 200);
        $(window).resize(function () {
            $table.bootstrapTable('resetView', {
                height: getHeight()
            });
        });
    }
    function nicknameFormatter(value, row, index) {
        var html = "";
        if (row.headimgurl == null || row.headimgurl == "") {
            html = '<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAoAAAAFCAYAAAB8ZH1oAAAALUlEQVQImWP8DwQMRAAWCPWWYWOeO0PzMWSpGIZ5ZwoY9KA8RmJNZCJGEUkKAXh/DgMb8RMjAAAAAElFTkSuQmCC" style="width:2px;height:2px;" onerror=""><br/>' + value;
        } else {
            html = '<img src="'+row.headimgurl+'" style="width:30px;height:30px;border-radius: 50%;padding:1px;" onerror=""><br/>' + value;
        }
        return html;

    }

    function informationFormatter(value, row, index) {
        if(value) {
            var html = '姓名：'+row.full_name+'<br/>手机号：' +value+'<br/> 微信：'+ row.wechat;
            return html;
        } else {
            return;
        }
    }
    function fatherNicknameFormatter(value, row, index){
        if(value){
            var html = '<img src="'+row.father_headimgurl+'" style="width:30px;height:30px;border-radius: 50%;padding:1px;" onerror=""><br/>' + value;
            return html;
        }
        return '无';
    }
    function joinFormatter(value, row, index) {
        var html = row.apply_status_Label+'<br>'+value;
        return html;

    }
    window.operateEvents = {
        'click .detail': function (e, value, row, index) {
            location.pathname = "/shop/fenxiao/member/" + row.weapp_user_id + '/detail';
        },
        'click .view_lowwer': function (e, value, row, index) {
            location.pathname = "/shop/fenxiao/member/" + row.weapp_user_id;
        },
        'click .view_order': function (e, value, row, index) {
            location.pathname = "/shop/fenxiao/member/" + row.weapp_user_id + "/order";
        }
    };

    function operateFormatter(value, row, index) {
        var operateDate = [
            '<a class="detail" href="javascript:void(0)" title="详情">',
            '详情',
            '</a>  ',
             '<a class="view_lowwer" href="javascript:void(0)" title="查看下级">',
            '查看下级',
            '</a>  ',
            '<a class="view_order" href="javascript:void(0)" title="查看订单">',
            '查看订单',
            '</a>  ',
        ];
        return operateDate.join('');
    }

    function getHeight() {
        return $(window).height() - $('.box-body').offset().top - 32;
    }

    initTable();

    $('#form').validator().on('submit', function (e) {
        if(!e.isDefaultPrevented()){
            e.preventDefault();
        }
        $table.bootstrapTable('selectPage', 1)

    });

    var systemlink = '';
    $.getJSON('/ajax/wechat/auth/show',function(json){
        var appid = json.data.appid;
        systemlink = 'http://'+systemlink+appid+'.h5.zuizan100.com.cn/fenxiao';
    });

    // 日期控件
    $('.datetimepicker_list').datetimepicker({
        autoclose: true,
        language: 'zh-CN',
        format: 'yyyy-mm-dd'
    });
    $('#downloadToExecl').click(function(){
        if (total_rows_record > 0) {
            var url = download_url_list + '&load=1';
            window.open(url);

        } else {
            bootbox.alert({
                title: '<span class="text-danger">详情</span>',
                message: '没有记录,导出EXCEL失败!'
            });
        }
    });

    $('#copylink').zclip({
        path: "{{asset('js/zclip/ZeroClipboard.swf')}}",
        copy: function(){
            return systemlink;
        },
        beforeCopy:function(){/* 按住鼠标时的操作 */
            $(this).css("color","orange");
        },
        afterCopy:function(){/* 复制成功后的操作 */
            $(this).text('复制成功');
        }
    });
    $(".fixed-table-container").removeAttr('height');
    $(".fixed-table-container").css('min-height', '278px');
    $.getJSON('/ajax/shop/fenxiao/level/name',function(json){
        var data = json.data;
        var level_text = '';
        data.forEach(function(item){
            level_text += "<option value='" + item.level+ "'>" + item.name + "</option>";
        });
        $('#level_name').append(level_text);
    })

});
</script>
@endpush
