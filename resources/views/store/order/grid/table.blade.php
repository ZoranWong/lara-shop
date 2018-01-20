<style>
    tbody>td, thead>th{
        text-align: center;
        vertical-align: middle;
    }

    thead>th .fht-cell{
        width: 100%;
    }
</style>
<div class="bg-white box-body">
    <div class="box-header d-flex">
        <div class="col-sm-12">
            {!! $grid->renderFilter() !!}
        </div>
        <div class="col-sm-12">
            <span class="float-left">
                {!! $grid->renderHeaderTools() !!}
            </span>

            <span class="float-right">
                {!! $grid->renderFilterButton() !!}
                {!! $grid->renderExportButton() !!}
                {!! $grid->renderCreateButton() !!}
            </span>
        </div>

    </div>
    <!-- /.box-header -->
    <div class="box-body table-responsive no-padding">
        <div class="bootstrap-table">
            <div class="fixed-table-toolbar" style="display: none;">
            </div>
            <div class="fixed-table-container">
                <div class="fixed-table-header">
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="fixed-table-body">
                    <table
                            id="{{$id}}"
                            data-toolbar="#toolbar"
                            data-striped="true"
                            data-pagination="false"
                            data-id-field="id"
                            class="table table-hover table-bordered">
                        <thead>
                            <tr id="trHeader">
                                <td style="width:450px; text-align: left;">
                                    <span style="margin-right: 75px;margin-left: 150px;">商品</span>
                                    <span style="margin-right: 20px;margin-left: 85px;">价格(数量)</span>
                                </td>
                                <td>售后</td>
                                <td>买家</td>
                                <td>下单时间</td>
                                <td>订单状态</td>
                                <td>实付金额</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($grid->rows() as $key => $row)
                                <tr data-index = "{{$key}}" {!! $row->getRowAttributes() !!}>
                                    {!! $row !!}
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                        {!! $grid->renderFooter() !!}
                        </tfoot>
                    </table>
                </div>
                <div class="fixed-table-footer">

                </div>
                <div class="fixed-table-paginating">

                </div>
            </div>
        </div>
    </div>
    <div class="box-footer clearfix">
        {!! $grid->paginator() !!}
    </div>
    <!-- /.box-body -->
</div>