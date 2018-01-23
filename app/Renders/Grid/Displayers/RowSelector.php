<?php

namespace App\Renders\Grid\Displayers;

use App\Renders\Facades\SectionContent;

class RowSelector extends \Encore\Admin\Grid\Displayers\RowSelector
{
    public function display()
    {
        $css = <<<CSS
.grid-row-checkbox{
    opacity: 0 !important;
}
CSS;

        SectionContent::css($css);
        SectionContent::script($this->script());

        return <<<EOT
<input type="checkbox" class="grid-row-checkbox"  data-id="{$this->getKey()}" />
EOT;
    }

    protected function script()
    {
        return <<<'EOT'
$('.grid-row-checkbox').iCheck({checkboxClass:'icheckbox_minimal-blue', "increaseArea":1}).css({
    position: "relative !important",
    top: 0,
    left: 0,
    display: "block",
    width: "auto",
    height: "auto",
    margin: "0px",
    padding: "0px",
    background: "rgb(255, 255, 255)",
    border: "0px",
    opacity: "0 !important",
}).on('ifChanged', function () {
    if (this.checked) {
        $(this).closest('tr').css('background-color', '#ffffd5');
    } else {
        $(this).closest('tr').css('background-color', '');
    }
});
EOT;
    }
}
