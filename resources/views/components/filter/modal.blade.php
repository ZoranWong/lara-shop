<div class="btn-group pull-right" style="margin-right: 10px">
    <button type="button" href="" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#filter-modal">
        <i class="fa fa-filter"></i>&nbsp;&nbsp;{{ trans('admin.filter') }}
    </button>
    <a href="{!! $action !!}" class="btn btn-sm btn-facebook"><i class="fa fa-undo"></i>&nbsp;&nbsp;{{ trans('admin.reset') }}</a>
</div>
<div class="modal fade" id="filter-modal" tabindex="-1" role="dialog" aria-labelledby="filter-modal-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" style="position: absolute;right: 32px;" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title pull-left m-auto" id="filter-modal-label">{{ trans('admin.filter') }}</h4>
            </div>
            <div id="toolbar" style="width:100%">
                <form action="{!! $action !!}" method="get" class="form-horizontal" pjax-container>
                    <div class="modal-body col-md-10">
                        @foreach($filters as $filter)
                            {!! $filter->render() !!}
                        @endforeach
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary submit">{{ trans('admin.submit') }}</button>
                        <button type="reset" class="btn btn-warning pull-left">{{ trans('admin.reset') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>