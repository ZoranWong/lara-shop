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

$("body").on("click", ".grid-refresh", function() {
    $.pjax.reload('#pjax-container');
    toastr.success('{$message}');
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
