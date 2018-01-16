<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Common\BasePage;
use App\Http\Controllers\Admin\Menu\Page;
use App\Models\Menu;
use App\Renders\Facades\SectionContent;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\BaseController as Controller;

class MenuController extends Controller
{
    public function __construct(Page $page)
    {
        $this->page = $page;
        $this->page->setModel(Menu::class);
    }

    public function index(): BasePage
    {
        $css = <<<CSS
.grid-row-checkbox{
    position: relative !important;
    opacity: inherit !important;
}
CSS;
        SectionContent::css($css);
        return $this->page->showTabs();
    }
}
