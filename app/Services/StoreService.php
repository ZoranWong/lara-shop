<?php
namespace App\Services;

use App\Models\Store;

class StoreService
{
    public static function getCurrentID() : int
    {
        return ($store = self::getCurrentStore()) ? $store['id'] : 1;
    }
    /**
     *
     * */
    public static function getCurrentStore()
    {
        $store = \Auth::guest()  ? null :  (!\Auth::user()->ownStore->first() ? null : \Auth::user()->managerStore->first());
        return ($store ? $store->toArray() : null) ;
    }
}
