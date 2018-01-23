<?php

namespace App\Filters;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Contracts\Routing\UrlGenerator;
use JeroenNoten\LaravelAdminLte\Menu\ActiveChecker as Checker;

class ActiveChecker extends Checker
{

    public function isActive($item)
    {

        if (isset($item['active'])) {
            return $this->isExplicitActive($item['active']);
        }



        if (isset($item['children'])) {
            return $this->containsActive($item['children']);
        }

        if (isset($item['href'])) {
            return $this->checkExactOrSub($item['href']);
        }

        // Support URL for backwards compatibility
        if (isset($item['url'])) {
            return $this->checkExactOrSub($item['url']);
        }

        return false;
    }

    private function isExplicitActive($active)
    {
        foreach ($active as $url) {
            if ($this->checkExact($url)) {
                return true;
            }
        }

        return false;
    }
}
