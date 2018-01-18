<?php
namespace App\Http\Controllers\Admin\Home\Store;
use App\Renders\Facades\SectionContent;

class JavaScript
{
    public function __construct()
    {
        SectionContent::script((function (){
            return <<<JS
JS;
        })());
        SectionContent::js((function (){
            return [];
        })());
    }
}