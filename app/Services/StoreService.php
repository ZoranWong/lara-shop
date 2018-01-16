<?php
namespace App\Services;

use App\Models\Store;

class StoreService
{
    public static function getCurrentID() : int
    {
        return ($store = self::getCurrentStore()) ? $store['id'] : 0;
    }
    /**
     *
     * */
    public static function getCurrentStore()
    {
        $store = \Auth::guest()  ? null :  (!\Auth::user()->ownStore->first() ? null : \Auth::user()->managerStore->first());
        logger('store',[$store, \Auth::guest(),\Auth::user()]);
        return ($store ? $store->toArray() : null) ;
    }
}