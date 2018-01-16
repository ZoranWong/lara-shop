@push('js')
//商品列表模版
<script type="text/template" id="activity-goods-select-template">
    <style>
        .activity-goods-select-list-box{
            display: block;
            top: 520px;
        }
        .title-image-goods {
            width: 54px;
            height: 54px;
            overflow: hidden;
            display: flex;
        }
        .title-image-goods img {
            width: 100%;
            height: 100%;
        }
        .activity-goods-select-title{
            position: absolute;
        }
        .activity-goods-select-list-box .page-list{
            display: none;
        }
    </style>
    {{--<div class = "activity-goods-select-mask"></div>--}}
    <div class = "activity-goods-select-list-box">
        <h4 class="activity-goods-select-title">商家已经上架商品</h4>
        <div class="activity-goods-select-box">
            <div class="activity-goods-select-box-body">
                <table id="activity-goods-select-goods-table"
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
                       data-url="/ajax/shop/activity/goods"
                       data-response-handler="responseHandler">
                </table>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>


    <script>
        var goodsListController = function () {
            var self = this;
            var $table = $('#activity-goods-select-goods-table');
            $table.bootstrapTable({
                //height: this.getHeight(),
                pagination: true,/*是否分页显示*/
                sidePagination: "server", /*分页方式：client客户端分页，server服务端分页*/
                smartDisplay: false,/*隐藏分页*/
                queryParams:this.queryParams,
                pageNumber: 1,
                pageSize: 4,
                columns:[
                    [
                        {
                            title: '标题',
                            field: 'name',
                            align: 'left',
                            valign: 'middle',
                            formatter:this.titleFormat
                        },
                        {
                            title:'售价',
                            field:'sell_price',
                            align: 'center',
                            valign: 'middle',
                            formatter:function (value, row, index) {
                                return value / 100;
                            }
                        },
                        {
                            title:'操作',
                            field:'id',
                            align: 'center',
                            valign: 'middle' ,
                            formatter:this.optFormat
                        }
                    ]
                ],
                responseHandler: function (res) {
                    return res.data;
                }
            });
        };
        goodsListController.prototype ={
            optFormat:function(value, row, index){
                var button = '<button data-bb-handler="Cancel" class = "btn btn-default" type = "button" '+(row['groupon_activities_count'] ? 'disabled="true"' : '' )+'>'+(row['groupon_activities_count'] ? '团购中' : '选取' )+'</button>';
                $('#activity-goods-select-goods-table').on('click','tr[data-index="'+index+'"]>td>button',function () {
                    goodsListCtrl.selectGoods(row);
                });
                return button;
            },
            titleFormat:function (value, row, index) {
                console.log(value);
                return '<div style="display: flex;"><div class = "title-image-goods" >'+'<img src="'+row['image_url']+'"></div>'
                    +'<div style="    text-align: center;padding: 16px 8px;"><span>'+row['name']+'</span></div></div>';
            },
            queryParams:function (params) {
                params.status = 1;
                return params;
            },
            getHeight:function () {
                return $('.activity-goods-select-box').height()  - $('.activity-goods-select-box-body').offset().top - 32;
            },
            selectGoods:function (goodsInfo) {
                addActivityController.selectGoods(goodsInfo);
                bootbox.hideAll();
            },
            remove:function(){

            },
            tableInit:function () {

            },
            show:function () {

            }
        }
        var goodsListCtrl = new goodsListController();
    </script>
</script>
@endpush