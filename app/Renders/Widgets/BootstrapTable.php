<?php
namespace App\Renders\Widgets;

class BootstrapTable extends Table
{
    /**
     * @var
     * */
    protected $toolbar = null;

    protected $pagination = null;
    protected function template(): string
    {
        // TODO: Change the autogenerated stub
        return <<<BOOTSTRAPTABLE
<div class="box-body" id="box-body">
    <table id="table"
        data-toolbar="#toolbar"
        data-striped="true"
        data-pagination="true"
        data-id-field="id"
        data-page-size="10"
        data-page-list="[10,15,20]"
        data-show-footer="false"
        data-side-pagination="server"
        data-url="/ajax/shop/goods/list"
        data-response-handler="responseHandler">
    </table>
</div>
BOOTSTRAPTABLE;
    }
}