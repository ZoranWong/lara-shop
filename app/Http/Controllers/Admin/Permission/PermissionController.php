<?php

namespace App\Http\Controllers\Admin\Permission;

use App\Http\Controllers\Admin\BaseController as Controller;
use App\Http\Controllers\Admin\Permission\Page;
use App\Models\Permission;

class PermissionController extends Controller
{
    public function __construct(Page $page)
    {
        $this->page = $page;

        $this->page->setModel(Permission::class);
        parent::__construct(function (){
           return [
               ['with' => ['menu']]
           ];
        });
    }
}
