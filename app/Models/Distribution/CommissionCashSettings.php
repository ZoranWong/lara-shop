<?php

namespace App\Models\Distribution;

use App\Models\Store;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Distribution\CommissionCashSettings
 *
 * @property int $id
 * @property int $store_id 店铺ID
 * @property float|null $min_cash_num 最低提现金额
 * @property float|null $max_cash_num 最高提现金额
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\CommissionCashSettings whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\CommissionCashSettings whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\CommissionCashSettings whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\CommissionCashSettings whereMaxCashNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\CommissionCashSettings whereMinCashNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\CommissionCashSettings whereStoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\CommissionCashSettings whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Store $store
 */
class CommissionCashSettings extends Model
{
    //
    protected $table = "commission_cash_settings";

    protected $fillable = [
        'id',
        'store_id',
        'min_cash_num',
        'max_cash_num'
    ];

    public function store() : BelongsTo
    {
        return $this->belongsTo(Store::class, 'store_id', 'id');
    }
}
