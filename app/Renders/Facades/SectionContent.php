<?php

namespace App\Renders\Facades;

use Illuminate\Support\Facades\Facade;
use Closure;
/**
 * @method static \App\Renders\Widgets\NavBar getNavBar()
 * @method static \App\Models\User user()
 * @method static \App\Renders\Layout\Content content($content)
 *  @method static \App\Renders\Widgets\Tab tab(Closure $callable)
 * @method static \App\Renders\Layout\Content addRow($content)
 * @method static \Illuminate\View\View css($css = null, $isLink = false)
 * @method static \Illuminate\View\View link($link = null)
 * @method static \Illuminate\View\View js($js = null)
 * @method static \Illuminate\View\View jsLoad($js = null, $script = null)
 * @method static \Illuminate\View\View script($script = '')
 * @method static \App\Renders\Grid grid($model, Closure $callable)
 * @method static \App\Renders\Form form($model, Closure $callable)
 * @method static \App\Renders\Tree tree($model, Closure $callable)
 * */
class SectionContent extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \App\Renders\SectionContent::class;
    }
}
