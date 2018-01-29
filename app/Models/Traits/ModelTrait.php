<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * model通用方法
 * */
trait ModelTrait
{
    /**
     * 作用域方法：结构化查询
     * @param Builder $query
     * @param array $where
     * @return Builder
     */
    public function scopeSearchBy(Builder $query, array $where) : Builder
    {
        $query = $this->magicWhere($query, $where);
        return $query;
    }

    /**
     * 结构化条件查询Builder构造器
     * @param  Builder $query
     * @param array $where
     * @return Builder
     * */
    public function magicWhere(Builder $query, array $where) :Builder
    {

        foreach ($where as $key => $value) {
            if(is_array($value)){
                $op = $value[0];
                $v  = $value[1];
                switch ($op) {
                    case 'in':
                        $query = $query->whereIn($key, $v);
                        break;
                    case 'raw':
                        $query = $query->whereRaw($v);
                        break;
                    default:
                        $query = $query->where($key,$op,$v);
                        break;
                }
            }else{
                $query = $query->where($key, $value);
            }
        }
        return $query;
    }
    /**
     * 作用域方法：根据id更新数据
     * @param Builder $query
     * @param int $id
     * @param array $data
     * @return null|Model
     * */
    public function scopeUpdateById(Builder $query, int $id, array $data) : Model
    {
        $model = $query->find($id);
        foreach ($data as $key => $value){
            $model->{$key} = $value;
        }
        return $model->save() ? $model : null;
    }

    /**
     * 作用域方法：根据id数组 delete记录
     * @param Builder $query
     * @param array $ids
     * @return int
     * */
    public static function scopeDeleteByIds(Builder $query, array $ids) : int
    {
       return $query->whereIn('id', $ids)->delete();
    }

}
