<?php

namespace App\Renders\Grid\Filter\Presenter;

use App\Renders\Facades\SectionContent;

class Checkbox extends Radio
{
    protected function prepare()
    {
        $script = "$('.{$this->filter->getId()}').iCheck({checkboxClass:'icheckbox_minimal-blue'});";

        SectionContent::script($script);
    }
}
