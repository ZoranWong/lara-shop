<?php
namespace App\Http\Controllers\Admin\Merchandise\Tools;

use App\Renders\Grid\Tools\BatchAction;

class OnShelvesBatch extends BatchAction
{
    protected $id='on-shelves';
    /**
     * Script of batch delete action.
     */
    public function script()
    {
        $onShelvesConfirm = '确认商家将这些商品上架吗？';
        $confirm = trans('admin.confirm');
        $cancel = trans('admin.cancel');
        $resource = "/ajax/merchandise/on";

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
                        $.pjax.reload('#pjax-container');
                        swal(data.data.message, '', 'success');
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