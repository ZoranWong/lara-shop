<?php

namespace App\Http\Controllers\Admin\Merchandise;

use App\Models\Merchandise;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\BaseController as Controller;

class MerchandiseController extends Controller
{
    //
    public function __construct(Page $page)
    {
        $this->page = $page;
        $page->setModel(Merchandise::class);
        parent::__construct(function (){
            return [];
        });
    }
}
