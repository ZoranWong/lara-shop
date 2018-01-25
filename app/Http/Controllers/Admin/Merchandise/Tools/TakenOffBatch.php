<?php
namespace App\Http\Controllers\Admin\Merchandise\Tools;

use App\Renders\Grid\Tools\BatchAction;

class TakenOffBatch extends BatchAction
{
    protected $id='taken-off';
    /**
     * Script of batch delete action.
     */
    public function script()
    {
        $onShelvesConfirm = '确认商家将这些商品下架吗？';
        $confirm = trans('admin.confirm');
        $cancel = trans('admin.cancel');
        $resource = "/ajax/merchandise/off";

        return <<<EOT

$('{$this->getElementClass()}').unbind('click').bind('click', function() {

    var id = selectedRows().join();

    swal({
      title: "$onShelvesConfirm",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "$confirm",
      closeOnConfirm: false,
      cancelButtonText: "$cancel"
    },
    function(){
        $.ajax({
            method: 'put',
            url: '{$resource}/' + id,
            data: {
                _method:'put',
                _token:'{$this->getToken()}'
            },
            success: function (data) {
                if (typeof data === 'object') {
                    if (data.success == true) {
                        swal(data.data.message, '', 'success');
                        $.pjax.reload('#pjax-container');
                    } else {
                        swal(data.error.message, '', 'error');
                    }
                }
            }
        });
    });
});

EOT;
    }
}