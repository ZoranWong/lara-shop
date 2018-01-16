<div class="row">
    <div class="col-xs-12">
        <div class="box" id = "end-box">
            <div class="box-body" id="end-box-body">
                <table id="end_groupon_table"
                       class="table table-striped"
                       data-toolbar="#toolbar"
                       data-search="true"
                       data-striped="true"
                       data-show-refresh="true"
                       data-strict-search="true"
                       data-search-on-enter-key="true"
                       data-pagination="true"
                       data-id-field="id"
                       data-page-size="10"
                       data-page-list="[10]"
                       data-show-footer="false"
                       data-side-pagination="server"
                       data-url="/ajax/shop/activity/groupon"
                       data-response-handler="responseHandler">
                </table>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->
</div>
@push('js')
<script>
    $(document).ready(function () {
        endActivityController = {
            status:'over_date',
            page:1,
            listUrl:'',
            deleteUrl:'',
            $table:$('#end_groupon_table'),
            searchKey:'',
            columns:function () {
                var self = this;
                return [
                    [
                        {
                            title: '活动名称',
                            field: 'activity_name',
                            align: 'left',
                            valign: 'middle',
                            class:  'td-activity-name',
                            sortable: false,
                        },
                        {
                            title: '有效期',
                            field: 'start_end_str',
                            align: 'left',
                            valign: 'middle',
                            class:  'td-activity-date',
                            sortable: false,
                        },
                        {
                            title: '活动状态',
                            field: 'status_str',
                            align: 'left',
                            valign: 'middle',
                            class: 'td-activity-status',
                            sortable: false,
                            formatter:function (value, row, index) {
                                return activityStatus(value,row);
                            }
                        },
                        {
                            title: '操作',
                            field: 'operate',
                            align: 'center',
                            valign: 'middle',
                            class: 'td-activity-opt',
                            events: OperateEvents(self),
                            formatter: function(value, row, index ){
                                return tableOptHtml(row);
                            }
                        }
                    ]
                ];
            },
            OperateEvents:function (grouponActivity) {

            },
            OperateFormatter:function () {

            },
            search:function (e) {
                if(!e.isDefaultPrevented()){
                    e.preventDefault();
                }
                this.$table.bootstrapTable('selectPage', 1)
            },
//            getHeight:function () {
//                return $('#end-box').height()  - $('#end-box-body').offset().top ;
//            },
            initTable: function () {
                var self = this;
                this.$table.bootstrapTable({
                    //height: self.getHeight(),
                    pagination: true,/*是否分页显示*/
                    sidePagination: "server", /*分页方式：client客户端分页，server服务端分页*/
                    smartDisplay: false,/*隐藏分页*/
                    queryParams:self.queryParams,
                    pageNumber: 1,
                    pageSize: 10,
                    columns:self.columns(),
                    responseHandler: function (res) {
                        if(res.data.total == 0){
                            $('.fixed-table-pagination').removeClass('pagination-show');
                            $('.fixed-table-pagination').addClass('pagination-hide');
                        }else{
                            $('.fixed-table-pagination').removeClass('pagination-hide');
                            $('.fixed-table-pagination').addClass('pagination-show');
                        }
                        return res.data;
                    }
                });
                setTimeout(function () {
                    self.$table.bootstrapTable('resetView');
                }, 200);

                $(window).resize(function () {
                    self.$table.bootstrapTable('resetView', {
                        //height: self.getHeight()
                    });
                });
            },
            queryParams: function (params){
                params['status'] = endActivityController.status;
                params['order'] = 'desc';
                return params;
            },
            reset:function () {
                var self = this;
                $('.nav-tabs li[data-status="end"]').addClass('active');
                $('.tab-content .tab-pane#end').addClass('active');
                this.$table.bootstrapTable('refresh');
            },
            leave:function () {
                var self = this;
                $('.nav-tabs li[data-status="end"]').removeClass('active');
                $('.tab-content .tab-pane#end').removeClass('active');
                this.$table.bootstrapTable('refresh');
            }
        };
        endActivityController.initTable();
    });
</script>
@endpush