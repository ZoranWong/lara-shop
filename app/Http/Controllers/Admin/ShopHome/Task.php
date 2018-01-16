<?php
namespace App\Http\Controllers\Admin\ShopHome;
use App\Renders\Widgets\Widget;
use Illuminate\Contracts\Support\Renderable;

class Task extends Widget implements Renderable
{
    protected $view = "shop.home.task";
    public function render()
    {
        logger($this->view);
        // TODO: Implement render() method.
        return view($this->view, $this->attributes);
    }
}