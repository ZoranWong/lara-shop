
<div id="toolbar_apply">
    <form class="form-horizontal" id="form_apply">
        <div class="col-md-3">
            <div class="input-group col-md-12">
                <div class="input-group-addon">分销商等级</div>
                <select class="select form-control" name="level_id" id="level_name_apply">
                    <option value="">请选择</option>
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="input-group col-md-12">
                <div class="input-group-addon">申请状态</div>
                <select class="select form-control" name="apply_status" id="apply_status">
                    <option value="">请选择</option>
                    <option value="1">待审核</option>
                    <option value="3">拒绝</option>
                </select>
            </div>
        </div>

        <div class="col-md-3">
            <div class="input-group col-md-12">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input type="text" name="apply_time" class="form-control pull-right datetimepicker_apply" placeholder="申请时间" readonly>

            </div>
        </div>
        <div class="col-md-3">
            <div class="input-group col-md-12">
            <div class="input-group-addon">昵称</div>
              <input type="text" class="form-control input" name="nickname" placeholder="昵称" maxlength="11" id="nickname">
            </div>
        </div>
        <div class="col-md-12" style="margin-top:15px;"></div>
        <div class="col-md-3" style="float: right;">
            <button type="submit" class="btn btn-primary">查询</button>
            <button type="reset" class="btn btn-info">重置</button>
            <button id="export" class="btn btn-inverse">导出</button>
        </div>
    </form>
</div>
<div class="col-md-6" style="position: absolute;top: 179px;">
    <button id="batch_through" class="btn btn-success" disabled>
        <i class="glyphicon glyphicon-ok"></i>批量通过
    </button>
    <button id="batch_deny" class="btn btn-danger" disabled>
        <i class="glyphicon glyphicon-remove"></i>批量拒绝
    </button>
</div>
<div class="box-body">
    <table id="table_apply"
           data-toolbar="#toolbar_apply"
           data-pagination="true"
           data-id-field="id"
           data-page-size="10"
           data-page-list="[10, 25, 50, 100]"
           data-show-footer="false"
           data-side-pagination="server"
           data-query-params="queryParams"
           data-url="/ajax/shop/fenxiao/member/list/{{ $id or '' }}"
           data-response-handler="responseHandler">
    </table>
</div>
<!-- /.box-body -->

@push('js')
<script>
$(document).ready(function () {
    var total_rows_record = 0;
    var downloadUrl = '';
    var $table = $('#table_apply'),
        $batch_through = $('#batch_through'),
        $batch_deny = $('#batch_deny'),
        selections = [];
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
                        field: 'state',
                        checkbox: true,
                        align: 'center',
                        valign: 'middle'
                    }, {
                        field: 'nickname',
                        title: '头像／昵称',
                        align: 'center',
                        valign: 'middle',
                        editable: true,
                        formatter: nicknameFormatter
                    }, {
                        field: 'levelName',
                        title: '用户等级',
                        align: 'center',
                        valign: 'middle'
                    }, {
                        field: 'full_name',
                        title: '姓名',
                        align: 'center',
                        valign: 'middle',
                        editable: true,
                    }, {
                        field: 'mobile',
                        title: '手机号',
                        align: 'center',
                        valign: 'middle',
                    }, {
                        field: 'wechat',
                        title: '微信号',
                        align: 'center',
                        valign: 'middle',
                        editable: true,
                    },{
                        valign: 'middle',
                        field: 'apply_time',
                        title: '申请时间',
                        sortable: true,
                        editable: true,
                        align: 'center'
                    }, {
                        field: 'join_time',
                        title: '审核时间',
                        valign: 'middle',
                        align: 'center',
                    }, {
                        field: 'apply_status_Label',
                        title: '申请状态',
                        editable: true,
                        valign: 'middle',
                        align: 'center'
                    }
                ]
            ],
            responseHandler: function (res) {
                total_rows_record = res.data.total;
                downloadUrl = res.data.params;
                return res.data;

            },
            'queryParams': function(params) {
                var arr = ['level_id','apply_status','apply_time','nickname'];
                params.apply_status = '1,3';
                arr.forEach(function(item){
                    if($('#form_apply [name='+item+']').val() == '' || typeof($('#form_apply [name='+item+']').val()) == 'undefined' ){
                    } else {
                        params[item] = $('#form_apply [name='+item+']').val();
                    }
                });
                return params;
            }

        });

        function nicknameFormatter(value, row, index) {
            var html = '<img src="'+row.headimgurl+'" style="width:30px;height:30px;border-radius: 50%;padding:1px;" onerror=""><br/>' + value;
            return html;
        }

        $table.on('check.bs.table uncheck.bs.table ' +
              'check-all.bs.table uncheck-all.bs.table', function () {
            $batch_through.prop('disabled', !$table.bootstrapTable('getSelections').length);
            $batch_deny.prop('disabled', !$table.bootstrapTable('getSelections').length);
            selections = getIdSelections();
        });
        $batch_through.click(function () {
            //批量操作分销商
            var ids = getIdSelections();
            var names = getNameSelections().join('、');
            if(confirm('确定批量通过分销商状态：' + names)) {

                $.post('/ajax/shop/fenxiao/member/batch', {'weapp_user_id': ids,'status' : 2}, function (json) {
                    if (json.code == 200) {
                        bootbox.alert({
                            title: '<span class="text-success">成功</span>',
                            message:'批量操作成功',
                            callback: function(){
                                $table.bootstrapTable('refresh', {});
                                $('#table').bootstrapTable('refresh', {});
                                $batch_through.prop('disabled', true);
                            }
                        });
                        
                    } else if (json.code == 401) {
                        location.pathname = '/login';
                    } else {
                        bootbox.alert({
                            title: '<span class="text-danger">失败</span>',
                            message: json.error
                        });
                    }
                }, 'json')
            }
        });

        $batch_deny.click(function () {
            //批量操作分销商
            var ids = getIdSelections();
            var names = getNameSelections().join('、');
            if(confirm('确定批量拒绝分销商申请状态：' + names)) {

                $.post('/ajax/shop/fenxiao/member/batch', {'weapp_user_id' : ids,'status' : 3}, function (json) {
                    if (json.code == 200) {
                        bootbox.alert({
                            title: '<span class="text-success">成功</span>',
                            message:'批量操作成功',
                            callback: function(){
                                $table.bootstrapTable('refresh', {});
                                $('#table').bootstrapTable('refresh', {});
                                $batch_deny.prop('disabled', true);
                            }
                        });
                        
                    } else if (json.code == 401) {
                        location.pathname = '/login';
                    } else {
                        bootbox.alert({
                            title: '<span class="text-danger">失败</span>',
                            message: json.error
                        });
                    }
                }, 'json')
            }
        });
        function getIdSelections() {
            return $.map($table.bootstrapTable('getSelections'), function (row) {
                  return row.weapp_user_id;
            });
        }

        function getNameSelections() {
            return $.map($table.bootstrapTable('getSelections'), function (row) {
                  return row.full_name;
            });
        }

        setTimeout(function () {
            $table.bootstrapTable('resetView');
        }, 200);
        $(window).resize(function () {
            $table.bootstrapTable('resetView', {
                height: getHeight()
            });
        });
    }

    function getHeight() {
        return $(window).height() - $('.box-body').offset().top - 32;
    }

    initTable();

    $('#form_apply').validator().on('submit', function (e) {
        if(!e.isDefaultPrevented()){
            e.preventDefault();
        }

        $table.bootstrapTable('selectPage', 1)
    });
    // 日期控件
    $('.datetimepicker_apply').datetimepicker({
        autoclose: true,
        language: 'zh-CN',
        format: 'yyyy-mm-dd'
    });

    $('#export').click(function(){
        if (total_rows_record > 0) {
            var url = downloadUrl + '&load=2';
            window.open(url);

        } else {
            bootbox.alert({
                title: '<span class="text-danger">详情</span>',
                message: '没有记录,导出EXCEL失败!'
            });
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
        $('#level_name_apply').append(level_text);
    })

})

</script>
@endpush