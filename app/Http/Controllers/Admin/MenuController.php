<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Common\BasePage;
use App\Http\Controllers\Admin\Menu\Page;
use App\Models\Menu;
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
        return $this->page->showTabs();
    }
}
