<?php

namespace App\Http\Controllers\Admin\Distribution;

use App\Http\Controllers\Admin\Common\BasePage;
use App\Models\Role;
use App\Models\Store;
use App\Services\StoreService;
use App\Http\Controllers\Admin\BaseController as Controller;
use Illuminate\View\View;

class DistributionController extends Controller
{
    //

    /**
     * @var Page $page
     * */
    protected $page = null;

    /**
     * @var Store
     * */
    protected $store = null;

    public function __construct(Page $page)
    {
        $this->page = $page;
        $this->store = StoreService::getCurrentStore();
        parent::__construct(function (){

        });
    }

    public function index(): BasePage
    {
        return $this->page->index()->with(['active' => 'index']);
    }

    public function setting() : BasePage
    {
        return $this->page->setting();
    }

    public function settingCash() : BasePage
    {
        return $this->page->settingCash();
    }

    public function settingCommission() : BasePage
    {
        return $this->page->settingCommission();
    }

    public function member() : BasePage
    {
        return $this->page->member();
    }

    public function memberApply() : BasePage
    {
        return $this->page->memberApply();
    }

    public function cash() : BasePage
    {
        return $this->page->cash();
    }
}
