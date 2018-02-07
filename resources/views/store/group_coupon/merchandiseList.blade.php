<script type="application/javascript">
    let merchandiseTemplate =
        `<style>
            .merchandise-select-list-box{
                display: block;
                top: 520px;
            }
            .title-image-merchandise {
                width: 54px;
                height: 54px;
                overflow: hidden;
                display: flex;
            }
            .title-image-merchandise img {
                width: 100%;
                height: 100%;
            }
            .merchandise-select-title{
                position: absolute;
            }
            .merchandise-select-list-box .page-list{
                display: none;
            }
        </style>
        <div class = "merchandise-select-list-box">
            <div class="merchandise-select-box">
                <div class="merchandise-select-box-body">
                    <table id="merchandise-select-table"
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
                           data-url="/ajax/merchandises"
                           data-response-handler="responseHandler">
                    </table>
                </div>
            </div>
        </div>`;

    let MerchandiseListController = function () {

    };
    MerchandiseListController.currentMerchandiseListController = null;
    MerchandiseListController.prototype = {
        open : function () {
            let self = this;
            MerchandiseListController.currentMerchandiseListController = self;
            this.dialog = bootbox.dialog({
                title : '商家已经上架商品',
                show : false,
                message: merchandiseTemplate,
                buttons: {
                    Cancel: {
                        label: '关闭',
                        className: "btn-default",
                        callback : function () {
                            console.log(this);
                        }
                    }
                }
            });
            this.dialog.init(function () {
                self.init();
            });
            this.dialog.modal('show');
        },
        close : function () {
            this.dialog.modal('hide');
        },
        events: [],
        init : function () {
            let self = this;
            $('#merchandise-select-table').bootstrapTable({
                pagination: true, /*是否分页显示*/
                sidePagination: "server", /*分页方式：client客户端分页，server服务端分页*/
                smartDisplay: false, /*隐藏分页*/
                queryParams: this.queryParams,
                dataField: "data",
                pageNumber: 1,
                pageSize: 4,
                columns: [
                    [
                        {
                            title: '标题',
                            field: 'name',
                            align: 'left',
                            valign: 'middle',
                            formatter: self.titleFormat
                        },
                        {
                            title: '售价',
                            field: 'sell_price',
                            align: 'center',
                            valign: 'middle',
                            formatter: function (value, row, index) {
                                return value / 100;
                            }
                        },
                        {
                            title: '操作',
                            field: 'id',
                            align: 'center',
                            valign: 'middle',
                            formatter: self.optFormat
                        }
                    ]
                ],
                responseHandler: function (res) {
                    return res.data;
                }
            });

            this.bindEvents();
        },
        bindEvents : function (key, callback) {
            if(key != undefined && callback != undefined && (this.events[key] == undefined || this.events[key] == null))
                (this.events[key] = []);
            if( key != undefined && callback != undefined )
                this.events[key].push( callback );
        },
        optFormat : function (value, row, index) {
            let button = `<button data-bb-handler="Cancel" class = "btn btn-default" type = "button" ${row['group_coupon_count'] ? 'disabled="true"' : ''}>
            ${row['group_coupon_count'] ? '团购中' : '选取' }</button>`;
            console.log(row);
            (function (row) {
                let merchandise = row;
                $('#merchandise-select-table').on('click',`tr[data-index="${index}"]>td>button`,function () {
                    if(typeof MerchandiseListController.currentMerchandiseListController.events['selectedMerchandise'] == 'object'){
                        $.each( MerchandiseListController.currentMerchandiseListController.events['selectedMerchandise'], function (indx, eventCallback) {
                            eventCallback(merchandise);
                        });
                    }

                    MerchandiseListController.currentMerchandiseListController.close();
                });
            })(row);

            return button;
        },
        titleFormat:function (value, row, index) {
            return `<div style="display: flex;">
                        <div class = "title-image-merchandise" >
                            <img src="${row['main_image_url']}">
                        </div>
                        <div style="text-align: center;padding: 16px 8px;">
                            <span>${row['name']}</span>
                        </div>
                    </div>`;
        },
        queryParams:function (params) {
            let queryParams = {};
            queryParams.status = 'ON_SHELVES';
            queryParams.page = this.pageNumber;
            return queryParams;
        },
        getHeight:function () {
            return $('.merchandise-select-box').height()  - $('.merchandise-select-box-body').offset().top - 32;
        },
    };
    window.MerchandiseListController = MerchandiseListController;
</script>