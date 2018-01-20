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
                    <table class="table table-hover table-striped">
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
                            class="table table-hover table-striped">
                        <thead>
                            <tr>
                                @foreach($grid->columns() as $column)
                                    @if($column->getLabel() != ' ' && $column->getLabel() != '')
                                        <th style="text-align: center;vertical-align: middle;" data-field="{{$column->getName()}}">
                                            <div class="th-inner ">
                                                {{$column->getLabel()}}{!! $column->sorter() !!}
                                            </div>
                                            <div class="fht-cell"></div>
                                        </th>
                                    @else
                                        <th style="text-align: center;vertical-align: middle;" class="bs-checkbox " data-field="state">
                                            <div class="th-inner ">
                                                <input class="grid-select-all" name="btSelectAll" type="checkbox">
                                            </div>
                                            <div class="fht-cell"></div>
                                        </th>
                                    @endif
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($grid->rows() as $key => $row)
                                <tr data-index = "{{$key}}" {!! $row->getRowAttributes() !!}>
                                    @foreach($grid->columnNames as $name)
                                        <td style="text-align: center;vertical-align: middle;" {!! $row->getColumnAttributes($name) !!}>
                                            {!! $row->column($name) !!}
                                        </td>
                                    @endforeach
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
<script>
    $(function () {
        $("#{{$id}}").on('click', 'input[name="btSelectAll"]', function () {

        });
    })
</script>