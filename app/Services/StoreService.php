<?php
namespace App\Services;

use App\Models\Store;

class StoreService
{
    /**
     * @return int
     * */
    public static function getCurrentID() : int
    {
        return ($store = self::getCurrentStore()) ? $store['id'] : 0;
    }
    /**
     * @return Store
     * */
    public static function getCurrentStore() : Store
    {
        $store = !\Request::user() ? null : ( !\Request::user()->ownStore->first() ?
            null : (\Request::user()->managerStore && \Request::user()->managerStore->first() ?
                \Request::user()->managerStore->first() : null));
        if(($storeId = \Request::input('store_id', null))){
            $s = $storeId ? Store::find($storeId) : null;
            if(!$store && $s){
                return $s;
            }
        }
        return $store ? $store : new Store();
    }
}
