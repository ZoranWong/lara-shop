<?php
namespace App\Http\Controllers\Admin\Common;
use App\Renders\Facades\SectionContent;

class Css
{
    public function __construct()
    {
        SectionContent::css((function(){
            return <<<CSS
.input-group-addon {
padding: 6px 12px;
font-size: 14px;
font-weight: 400;
line-height: 2;
color: #555;
text-align: center;
background-color: #eee;
border: 1px solid #ccc;
border-radius: 4px;
}
.col-form-label.control-label{
text-align: right;
}
CSS;
        })());
    }
}