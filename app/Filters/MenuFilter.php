<?php
namespace App\Filters;

use App\Models\User;
use JeroenNoten\LaravelAdminLte\Menu\Filters\FilterInterface;
use Auth;
use Zizaco\Entrust\Entrust;

class MenuFilter implements FilterInterface
{
    public function __construct()
    {
    }

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
        return ! isset($item['can']) || Entrust::can($item['can']);
    }
}