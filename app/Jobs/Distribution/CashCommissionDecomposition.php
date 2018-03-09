<?php

namespace App\Jobs\Distribution;

use App\Models\Distribution\CommissionCashApply;
use App\Models\Distribution\CommissionCashDetail;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CashCommissionDecomposition implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $cashCommissionId = null;

    protected $limit = 200;
    /**
     * Create a new job instance.
     * @param int $id
     * @param int $limit
     * @return void
     */
    public function __construct(int $id, int $limit = 200)
    {
        //
        $this->cashCommissionId = $id;

        $this->limit = $limit;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $applyInfo = CommissionCashApply::where('id', $this->cashCommissionId)
            ->where('status', '0')
            ->first();
        if (!$applyInfo) {
            return ;
        }
        $cashApplyId = $applyInfo->id;
        $ApplyCount = ceil($applyInfo->amount / $this->limit);
        $limit = $this->limit;
        $k = 1;
        /*提现时 生成N个不重复的随机数*/
        $tradeNo = $this->str_rand_no($ApplyCount);
        $apply = [];
        $amount = $applyInfo->amount - ($limit * ($ApplyCount - 1));
        /*拆分金额存入到打款详情 单条打款记录200元 超过200元再增加一条记录*/
        for ($i=0;$i<$ApplyCount;$i++) {
            $cashId = $cashApplyId.printf('%04d', $i);
            $extra = $applyInfo->amount - $limit * $i;
            $extra = $extra > $limit ? $limit : $extra;
            /*如果订单只有一笔 就不用增加与减少1元*/
            if (($ApplyCount > 1) && ($amount < 1)) {
                if ($i == $ApplyCount-2) {
                    $extra -= 1;
                }
                if ($i == $ApplyCount-1) {
                    $extra += 1;
                }
            }

            $apply[] = [
                'store_id' => $applyInfo->store_id,
                'distribution_member_id' => $applyInfo->distribution_member_id,
                'distribution_user_id' => $applyInfo->distribution_user_id,
                'commission_cash_apply_id' => $cashApplyId,
                'cash_id' => $cashId,
                'mobile'  => $applyInfo->mobile,
                'name'    => $applyInfo->name,
                'remark'  => $applyInfo->remark,
                'apply_time' => $applyInfo->apply_time,
                'cash_time' => null,
                'amount' => $extra,
                'trade_no' => $tradeNo[$i],
                'wait_amount' => $extra,
                'pay_amount' => 0,
                'status' => 0
            ];
            $k++;
        }
        CommissionCashDetail::insert($apply);
    }

    /*提现时 生成N个不重复的随机数*/
    protected function str_rand_no($count){
        $count = intval($count);
        if ($count <= 0) {
            return false;
        }
        $rand = [];
        for ($i=0;$i<$count;$i++) {
            $rand[] = str_random(10);
        };
        $extraCount = CommissionCashDetail::whereIn('trade_no', $rand)->count();
        if ($extraCount > 0) {
            $this->str_rand_no($count);
        }
        return $rand;
    }
}
