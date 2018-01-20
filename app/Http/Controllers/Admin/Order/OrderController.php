<?php

namespace App\Http\Controllers\Admin\Order;

use App\Http\Controllers\Admin\BaseController as Controller;
use Illuminate\Support\Facades\Input;

class OrderController extends Controller
{
    public function __construct(Page $page)
    {
        $this->page = $page;
        parent::__construct(function (){
            return [

            ];
        });
    }
}
