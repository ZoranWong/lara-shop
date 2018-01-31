<?php
namespace App\Filters;

use App\Models\User;
use JeroenNoten\LaravelAdminLte\Menu\Builder;
use JeroenNoten\LaravelAdminLte\Menu\Filters\FilterInterface;
use Auth;

class MenuFilter implements FilterInterface
{
    public function transform($item, Builder $builder)
    {
        if (! $this->isVisible($item)) {
            return false;
        }

        if (isset($item['header'])) {
            $item = $item['header'];
        }

        return $item;
    }

    protected function isVisible($item)
    {
        $id = Auth::id();
        if($id == User::SUPER_ADMIN_ID) {
            return true;
        }
        $can = [];
        $can[] = $item['permission']['name'];
        logger($item['text']);
        return Auth::user()->can($can);
    }
}