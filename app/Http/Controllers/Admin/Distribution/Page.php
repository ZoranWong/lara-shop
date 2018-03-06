<?php
namespace App\Http\Controllers\Admin\Distribution;
use \App\Http\Controllers\Admin\Common\BasePage;
use App\Models\Distribution\ApplySetting;
use App\Services\StoreService;
use Illuminate\View\View;

class Page extends BasePage
{
    /**
     * @var View
     * */
    protected $subView = null;

    /**
     * @var View
     * */
    protected $layouts = null;

    public function __construct()
    {
        parent::__construct();
        $this->layouts = view('store.distribution.layouts');

        $this->setBoxTitle('分销管理');
    }

    public function index() : Page
    {
        \View::composer('store.distribution.layouts', function (View $view){
            $view->with('active', 'index');
            $view->with('store_id', \Request::get('store_id'));
        });
        $this->box->content(view('store.distribution.order.home')
            ->with('store_id', \Request::get('store_id')));
        return $this;
    }

    public function setting() : Page
    {
        \View::composer('store.distribution.layouts', function (View $view){
            $view->with('active', 'setting');
            $view->with('store_id', \Request::get('store_id'));
        });
        \View::composer('store.distribution.setting.index', function (View $view){
            $view->with('active', 'basic');
            $view->with('store_id', \Request::get('store_id'));
        });
        $this->box->content(view('store.distribution.setting.basic.index')
            ->with('store_id', \Request::get('store_id'))
            ->with('setting', ApplySetting::whereStoreId(\Request::get('store_id'))->first()));
        return $this;
    }

    public function settingCash() : Page
    {
        \View::composer('store.distribution.layouts', function (View $view){
            $view->with('active', 'setting');
            $view->with('store_id', \Request::get('store_id'));
        });
        \View::composer('store.distribution.setting.index', function (View $view){
            $view->with('active', 'cash');
            $view->with('store_id', \Request::get('store_id'));
        });
        $this->box->content(view('store.distribution.setting.cash.index')
            ->with('store_id', \Request::get('store_id')));
        return $this;
    }

    public function settingCommission() : Page
    {
        \View::composer('store.distribution.layouts', function (View $view){
            $view->with('active', 'setting');
            $view->with('store_id', \Request::get('store_id'));
        });
        \View::composer('store.distribution.setting.index', function (View $view){
            $view->with('active', 'commission');
            $view->with('store_id', \Request::get('store_id'));
        });
        $this->box->content(view('store.distribution.setting.commission.index')
            ->with('store_id', \Request::get('store_id')));
        return $this;
    }

    public function member() : Page
    {
        \View::composer('store.distribution.layouts', function (View $view){
            $view->with('active', 'member');
            $view->with('store_id', \Request::get('store_id'));
        });

        \View::composer('store.distribution.member.index', function (View $view){
            $view->with('active', 'list');
            $view->with('store_id', \Request::get('store_id'));
        });
        $this->box->content(view('store.distribution.member.list.index')
            ->with('store_id', \Request::get('store_id')));
        return $this;
    }

    public function memberApply() : Page
    {
        \View::composer('store.distribution.layouts', function (View $view){
            $view->with('active', 'member');
            $view->with('store_id', \Request::get('store_id'));
        });

        \View::composer('store.distribution.member.index', function (View $view){
            $view->with('active', 'apply');
            $view->with('store_id', \Request::get('store_id'));
        });
        $this->box->content(view('store.distribution.member.apply.index')
            ->with('store_id', \Request::get('store_id')));
        return $this;
    }


    public function cash() : Page
    {
        \View::composer('store.distribution.layouts', function (View $view){
            $view->with('active', 'cash');
            $view->with('store_id', \Request::get('store_id'));
        });
        $this->box->content(view('store.distribution.cash.index')
            ->with('store_id', \Request::get('store_id')));
        return $this;
    }
}