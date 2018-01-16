<div class="box">
    <div id="toolbar">
        {{ $tools->render() }}
    </div>
    <div class="box-body">
        <table id="table"
               data-toolbar="#toolbar"
               data-search="true"
               data-striped="true"
               data-show-refresh="true"
               data-strict-search="true"
               data-search-on-enter-key="true"
               data-pagination="true"
               data-id-field="id"
               data-page-size="10"
               data-page-list="[10, 25, 50, 100, ALL]"
               data-show-footer="{{ $footer }}"
               data-side-pagination="server"
               data-url="{{ $url }}"
               data-response-handler="responseHandler">
        </table>
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->