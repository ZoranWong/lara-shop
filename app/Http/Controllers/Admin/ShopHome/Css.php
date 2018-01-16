<?php
namespace App\Http\Controllers\Admin\ShopHome;
use App\Renders\Facades\SectionContent;

class Css
{
    public function __construct()
    {
        SectionContent::css((function(){
            return <<<CSS
.panel {
    margin-top: 20px;
}
.row {
    font-size: 16px;
    margin-top:10px;
    margin-bottom: 10px;
}
.col-xs-4 {
    margin-bottom: 10px;
}
.manager-image {
    float: left;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    margin-right: 10px;
    margin-top: -2px;
}
.card-group>.card{
    flex: none;
}
CSS;
        })());
    }
}