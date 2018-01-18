<?php
namespace App\Http\Controllers\Admin\Common;
use App\Renders\Facades\SectionContent;

class Css
{
    protected $boxCss = <<<BOXCSS
.box{
    border-top: none !important;
}
BOXCSS;
    protected $boxHeaderCss = <<<BOXHEADERCSS
.box-header{
    padding: 16px 12px 12px 16px !important;
}
BOXHEADERCSS;


    protected $navTabsCustomCss = <<<NAVTABSCUSTOM
.nav-tabs-custom{
    box-shadow: none !important;
}
NAVTABSCUSTOM;


    public function __construct()
    {
        SectionContent::css($this->boxCss);
        SectionContent::css($this->navTabsCustomCss);
        SectionContent::css($this->boxHeaderCss);
    }
}