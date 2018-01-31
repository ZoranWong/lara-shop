<?php

namespace App\Renders\Grid\Tools;

use App\Renders\SectionContent;

class RefreshButton extends AbstractTool
{
    /**
     * Script for this tool.
     *
     * @return string
     */
    protected function script()
    {
        $message = trans('admin.refresh_succeeded');

        return <<<EOT

$(".grid-refresh").unbind('click').bind('click', function() {
    $.pjax.reload('#pjax-container');
    toastr.options.onShown = function() { 
        console.log('hello', window.successRefresh); 
        window.successRefresh = 'start';
    }
    toastr.options.onHidden = function() { 
        console.log('goodbye', window.successRefresh); 
        window.successRefresh = 'end';
    }
    toastr.options.onclick = function() { 
        console.log('clicked'); 
    }
    toastr.options.onCloseClick = function() {
        console.log('close button clicked'); 
        window.successRefresh = 'end';
    }
    if(window.successRefresh != 'start'){
        toastr.success('{$message}');
    }
});

EOT;
    }

    /**
     * Render refresh button of grid.
     *
     * @return string
     */
    public function render()
    {
        SectionContent::script($this->script());

        $refresh = trans('admin.refresh');

        return <<<EOT
<a class="btn btn-sm btn-primary grid-refresh"><i class="fa fa-refresh"></i> $refresh</a>
EOT;
    }
}
