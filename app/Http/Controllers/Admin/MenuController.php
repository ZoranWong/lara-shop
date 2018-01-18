<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Common\BasePage;
use App\Http\Controllers\Admin\Menu\Page;
use App\Models\Menu;
use App\Models\Permission;
use App\Renders\Facades\SectionContent;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\BaseController as Controller;
use Illuminate\Support\Facades\Input;

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

    public function store(): \Symfony\Component\HttpFoundation\Response
    {
        \DB::beginTransaction();
        try{
            $permissionData = [
                'name' => 'menu-'.str_random(),
                'display_name' => '菜单-'.Input::get('text'),
            ];
            $permission = Permission::create($permissionData);
            app('request')['permission_id'] = $permission['id'];
            if(Input::get('roles')){
                $permission->roles()->sync(array_filter(Input::get('roles')));
                unset(app('request')['roles']);
            }
            if(app('request')['parent_id'] == 0){
                unset(app('request')['parent_id']);
            }
            logger('input all', Input::all());
            $result = $this->page->form()->store();
            \DB::commit();
            return $result;
        }catch (\Exception $exception){
            \DB::rollBack();
           return back()->withInput()->withErrors($exception->getMessage());
        }

    }
}
