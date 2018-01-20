<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\Common\ModelForm;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Common\BasePage;

class BaseController extends Controller
{
    use ModelForm;
    /**
     * @var BasePage $page
     * */
    protected $page = null;

    public function __construct(\Closure $callback)
    {
        $this->page->conditions($callback);
    }
}