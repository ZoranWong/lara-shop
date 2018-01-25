<?php
namespace App\Services;

use App\Models\Store;

class StoreService
{
    public static function getCurrentID() : ?int
    {
        return ($store = self::getCurrentStore()) ? $store['id'] : null;
    }
    /**
     *
     * */
    public static function getCurrentStore() : ?array
    {
        $store = \Auth::guest()  ? null :  (!\Auth::user()->ownStore->first() ? null : \Auth::user()->managerStore->first());
        return ($store ? $store->toArray() : null) ;
    }
}
