<?php

namespace App\Filters;

use JeroenNoten\LaravelAdminLte\Menu\Builder;
use JeroenNoten\LaravelAdminLte\Menu\Filters\FilterInterface;

class ChildrenFilter implements FilterInterface
{
    public function transform($item, Builder $builder)
    {
        if (isset($item['children'])) {
            $item['children'] = $builder->transformItems($item['children']);
            $item['children_open'] = $item['active'];
            $item['children_classes'] = $this->makeSubmenuClasses();
            $item['children_class'] = implode(' ', $item['children_classes']);
        }

        return $item;
    }

    protected function makeSubmenuClasses()
    {
        $classes = ['treeview-menu'];

        return $classes;
    }
}
