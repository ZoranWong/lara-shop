<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\OrderStaticsDaily
 *
 * @property int $id
 * @property int $store_id 商铺ID
 * @property float $today_amount 今日销售金额
 * @property int $today_sales 今日销量
 * @property float $today_distribution_amount 今日分销销售金额
 * @property int $today_distribution_sales 今日分销订单量
 * @property float $today_commission_amount 今日分销佣金
 * @property float $today_commission_paid_amount 今日分销佣金已提现
 * @property float $today_commission_apply_amount 今日分销佣金待提现
 * @property string $statics_date 统计日期
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderStaticsDaily whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderStaticsDaily whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderStaticsDaily whereStaticsDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderStaticsDaily whereStoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderStaticsDaily whereTodayAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderStaticsDaily whereTodayCommissionAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderStaticsDaily whereTodayCommissionApplyAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderStaticsDaily whereTodayCommissionPaidAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderStaticsDaily whereTodayDistributionAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderStaticsDaily whereTodayDistributionSales($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderStaticsDaily whereTodaySales($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderStaticsDaily whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class OrderStaticsDaily extends Model
{
    //
    protected $table = "order_statics_daily";
}
