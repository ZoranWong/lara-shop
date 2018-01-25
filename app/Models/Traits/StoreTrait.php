<?php

namespace App\Models\Traits;

use Closure;
use Illuminate\Database\Eloquent\Builder;

trait StoreTrait
{
    /**
     * 限制查询某个店铺信息。
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCurrentStore(Builder $query)
    {
        $storeId = \App\Services\StoreService::getCurrentID();
        return $query->where('store_id', '=', $storeId);
    }

    /**
     * ajax接口查询信息 for store
     * @param array $where
     * @param int $offset
     * @param int $limit
     * @param string $sort
     * @param string $order
     * @param array $with
     * @param array $whereHas
     * @return array
     */
    public static function ajaxSearchForStore(
        array $where,
        int $offset = 0,
        int $limit = 10,
        string $sort = 'id',
        string $order = 'desc' ,
        array $with = [],
        array $whereHas=[])
    {
        $modelObj = new static;
        $modelObj = $modelObj->store()->magicWhere($where);

        $total = $modelObj->count();
        if($with) {
            $modelObj = $modelObj->with($with);
        }
        if($whereHas) {
            foreach ($whereHas as $key => $item) {
                if($item instanceof Closure) {
                    $modelObj = $modelObj->whereHas($key,$item);
                }
            }
        }
        $list  = $modelObj->orderBy($sort,$order)->offset($offset)->limit($limit)->get();

        return ['total' => $total,'rows' => $list];
    }

    public static function findForStore($id)
    {
        return (new static)->store()->find($id);
    }

    public static function updateForStore($id,array $data)
    {
        $primary_id = (new static)->primaryKey;
        $model = (new static)->store()->where($primary_id,$id)->first();
        if($model){
            return $model->update($data);
        }
        return false;
    }

    public static function deleteForStoreByIds($ids)
    {
        return (new static)->store()->whereIn('id', $ids)->delete();
    }

    public static function createForStore(array $data)
    {
        $storeId          = \App\Services\StoreService::getCurrentID();
        $data['store_id'] = $storeId;

        return (new static)->create($data);
    }
}
