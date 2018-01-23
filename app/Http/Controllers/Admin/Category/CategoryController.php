<?php

namespace App\Http\Controllers\Admin\Category;

use App\Models\Category;
use App\Http\Controllers\Admin\BaseController as Controller;

class CategoryController extends Controller
{
    //
    public function __construct(Page $page)
    {
        $this->page = $page;
        $page->setModel(Category::class);
        parent::__construct(function (){
           $conditions = [];
           $conditions[] = ['withCount' =>['merchandises']];
           return $conditions;
        });
    }
}
