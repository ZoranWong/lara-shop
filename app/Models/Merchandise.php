<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\ModelTrait;
use App\Models\Traits\StoreTrait;
use Illuminate\Database\Query\Builder;
use Exception;


class Merchandise extends Model
{
    use ModelTrait ,StoreTrait , SoftDeletes;

    /**
     * 与模型关联的数据表
     *
     * @var string
     */
    protected $table = 'merchandise';

    const   STATUS = [
        'TAKEN_OFF'  => 'UNDER',//商品下架
        'ON_SHELVES' => 'ON',//商品上架
        'SELL_OUT'   => 'SELL_OUT',//售罄
        'DELETE'     => 'DELETE',//已删除
    ];

    protected $casts = [
        'spec_array' => 'array'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'store_id','category_id','code','name','main_image_url','sell_price','max_price',
        'min_price','stock_num','sell_num','sort','brief_introduction','content',
        'spec_array','status','deleted_at'
    ];

    protected static function boot()
    {
        parent::boot();
    }

    public function product(){
        return $this->hasMany(Product::class,'merchandise_id','id');
    }

}
