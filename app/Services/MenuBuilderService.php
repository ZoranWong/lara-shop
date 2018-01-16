<?php
namespace App\Services;

use App\Models\Menu;

class MenuBuilderService
{
    protected $menu = [];

    public function __construct()
    {
    }
    /**
     * @return array
     * */
    public static function menus() : array
    {
        $menus = Menu::get()->toArray();
        return $menus;
    }
}