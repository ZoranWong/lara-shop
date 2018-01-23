<?php
namespace App\Http\Controllers\Admin\Home\Store;
use App\Renders\Widgets\Widget;
use Illuminate\Contracts\Support\Renderable;

class Task extends Widget implements Renderable
{
    protected $view = "store.home.task";
    public function render()
    {
        // TODO: Implement render() method.
        return view($this->view, $this->attributes);
    }
}