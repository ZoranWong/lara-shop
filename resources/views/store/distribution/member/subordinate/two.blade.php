<div id="toolbar_two">
    <form class="form-horizontal" id="form_two">
        <div class="col-md-3">
            <div class="input-group col-md-12">
                <div class="input-group-addon">ID</div>
                <input type="text" class="form-control input" name="fans_id" placeholder="ID" maxlength="60">
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
        <div class="col-md-12" style="height: 15px;"></div>
        <div class="col-md-3">
            <div class="input-group col-md-12">
                <div class="input-group-addon">分销商等级</div>
                <select class="select form-control" name="level_id" id="level_name_two">
                    <option value="">请选择</option>
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="input-group col-md-12">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input type="text" name="join_time_start" class="form-control pull-right datetimepicker" placeholder="加入时间(开始)" readonly>

            </div>
        </div>
        <div class="col-md-3">
            <div class="input-group col-md-12">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input type="text" name="join_time_end" class="form-control pull-right datetimepicker" placeholder="加入时间(结束)" readonly>

            </div>
        </div>

        <div class="col-md-3" style="float: right;">
            <button type="submit" class="btn btn-primary">搜索</button>
            <button type="reset" class="btn btn-info">重置</button>
            <button id="download_two" class="btn btn-default">导出Excel</button>
        </div>
    </form>
</div>

<div class="box-body">
    <table id="table_two"
           data-toolbar="#toolbar_two"
           data-pagination="true"
           data-id-field="fans_id"
           data-page-size="10"
           data-page-list="[10, 25, 50, 100]"
           data-show-footer="false"
           data-side-pagination="server"
           data-query-params="queryParams"
           data-url="/ajax/fenxiao/member/list/{{ $id }}/2" 
           data-response-handler="responseHandler">
    </table>
</div>
@push('js')
<script type="text/javascript">
    var total_rows_record_two = 0;
    var download_url_two = '';
    var $table_two = $('#table_two');
    function initTable() {
        $table_two.bootstrapTable({
            pagination: true,/*是否分页显示*/
            sidePagination: "server", /*分页方式：client客户端分页，server服务端分页*/
            smartDisplay: false,/*隐藏分页*/
            paginationPreText: "上一页",
            paginationNextText: "下一页",
            pageNumber: 1,
            pageSize: 10,
            striped: true,
            height: getHeight(),
            columns: [
                [
                    {
                        field: 'fans_id',
                        title: 'ID',
                        align: 'center',
                        valign: 'middle',
                        sortable: true,
                    }, {
                        field: 'full_name',
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
                        align: 'center'
                    }, {
                        field: 'father_nickname',
                        valign: 'middle',
                        title: '推荐人',
                        editable: true,
                        align: 'center',
                        formatter: fatherNicknameFormatter
                    }, {
                        field: 'referrals',
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
              $('#subordinate_nums_level_two').text(res.data.total);
                total_rows_record_two = res.data.total;
                download_url_two = res.data.params;
                return res.data;

            },
            'queryParams': function(params){
                var arr = ['fans_id','full_name','mobile','level_id','join_time_start','join_time_end','apply_status','level_id'];
                arr.forEach(function(item){
                    if($('#form_two [name='+item+']').val() == '' || typeof($('#form_two [name='+item+']').val()) == 'undefined' ) {

                    } else {
                        params[item] = $('#form_two [name='+item+']').val();
                    }
                });
                return params;
            }
        });

        setTimeout(function () {
            $table_two.bootstrapTable('resetView');
        }, 200);
        $(window).resize(function () {
            $table_two.bootstrapTable('resetView', {
                height: getHeight()
            });
        });
    }
    function nicknameFormatter(value, row, index) {
        var html = '<img src="'+row.headimgurl+'" style="width:30px;height:30px;border-radius: 50%;padding:1px;" onerror=""><br/>' + value;
        return html;
    }

    function informationFormatter(value, row, index) {
        if(value) {
            var html = '姓名：'+row.full_name+'<br/>手机号：' +value+'<br/> 微信：'+ row.wechat;
            return html;
        } 
        return;
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
            location.pathname = "/fenxiao/member/" + row.fans_id + '/detail';
        },
        'click .view_lowwer': function (e, value, row, index) {
            location.pathname = "/fenxiao/member/" + row.fans_id;
        },
        'click .view_order': function (e, value, row, index) {
            location.pathname = "/fenxiao/member/" + row.fans_id + "/order";
        }
    };

    function operateFormatter(value, row, index) {
        var operateDate = [
            '<a class="detail" href="javascript:void(0)" title="详情">',
            '详情',
            '</a>  ',
            '<a class="view_order" href="javascript:void(0)" title="查看订单">',
            '查看订单',
            '</a>  ',
             '<a class="view_lowwer" href="javascript:void(0)" title="查看下级">',
            '查看下级',
            '</a>  ',
        ];
        return operateDate.join('');
    }

    
    function getHeight() {
        return $(window).height() - $('.box-body').offset().top - 32;
    }

    initTable();

    $('#form_two').validator().on('submit', function (e) {
        if(!e.isDefaultPrevented()){
            e.preventDefault();
        }
        $table_two.bootstrapTable('selectPage', 1)

    });
    // 日期控件
    $('.datetimepicker').datetimepicker({
        autoclose: true,
        language: 'zh-CN',
        format: 'yyyy-mm-dd'
    });
    $('#download_two').click(function(){
        if (total_rows_record_two > 0) {
            var url = download_url_two + '&load=3';
            window.open(url);

        } else {
            bootbox.alert({
                title: '<span class="text-danger">提示</span>',
                message: '没有记录,导出EXCEL失败!'
            });
        }
    });
    $.getJSON('/ajax/fenxiao/level/name',function(json){
        var data = json.data;
        var level_text = '';
        data.forEach(function(item){
            level_text += "<option value='" + item.level+ "'>" + item.name + "</option>";
        });
        $('#level_name_two').append(level_text);
    })
</script>
@endpush