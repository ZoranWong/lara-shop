<?php

namespace App\Renders\Grid\Displayers;

use App\Renders\SectionContent;

class RowSelector extends \Encore\Admin\Grid\Displayers\RowSelector
{
    public function display()
    {
        SectionContent::script($this->script());

        return <<<EOT
<input type="checkbox" class="grid-row-checkbox" data-id="{$this->getKey()}" />
EOT;
    }

    protected function script()
    {
        return <<<'EOT'
$('.grid-row-checkbox').iCheck({checkboxClass:'icheckbox_minimal-blue'}).on('ifChanged', function () {
    if (this.checked) {
        $(this).closest('tr').css('background-color', '#ffffd5');
    } else {
        $(this).closest('tr').css('background-color', '');
    }
});
EOT;
    }
}
