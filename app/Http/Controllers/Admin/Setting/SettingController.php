<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Http\Controllers\Admin\Common\BasePage;
use App\Http\Controllers\Admin\Setting\Page;
use App\Models\User;
use App\Renders\Facades\SectionContent;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\BaseController as Controller;

class SettingController extends Controller
{
    //

    public function __construct(Page $page)
    {
        $this->page = $page;
        $this->page->setModel(User::class);
    }

    public function index(): BasePage
    {
        SectionContent::link(asset('/vue/css/app.css'));
        SectionContent::js(asset('/vue/js/app.js'));
        return parent::edit(\Auth::id());
    }
}
