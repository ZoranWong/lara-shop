<?php

namespace App\Http\Controllers\Admin\Role;

use App\Http\Controllers\Admin\Common\BasePage;
use App\Http\Controllers\Admin\Role\Page;
use App\Models\Role;
use App\Http\Controllers\Admin\BaseController as Controller;
use Illuminate\Support\Facades\Input;

class RoleController extends Controller
{
    public function __construct(Page $page)
    {
        $this->page = $page;
        $this->page->setModel(Role::class);
    }

    public function edit($id): BasePage
    {
        if(($permissions = Input::get('permissions'))){
            $permissions = array_filter($permissions);
            app('request')['permissions'] = $permissions;
        }
        return parent::edit($id);
    }
}
