<?php

namespace App\Jobs\Distribution;

use App\Models\Distribution\CommissionCashApply;
use App\Models\Distribution\CommissionCashDetail;
use App\Models\Distribution\Member;
use App\Notifications\Wechat\CommissionExtractApply;
use App\Wechat\MerchantPayment;
use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use \EasyWeChat\Payment\Transfer\Client as Transfer;

class CashCommission implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var MerchantPayment
     * */
    protected $merchantPayment;
    /**
     * @var Collection
     * */
    protected $cashDetailList;

    /**
     * @var int
     * */
    protected $storeId;

    /**
     * @var CommissionCashApply
     * */
    protected $cashApply = null;

    /**
     * @var Transfer
     * */
    protected $transfer = null;
    /**
     * Create a new job instance.
     * @param integer $storeId
     * @param MerchantPayment $merchantPayment
     * @param $cashApply
     * @param Collection $cashDetailList
     * @return void
     */
    public function __construct(int $storeId, MerchantPayment $merchantPayment, CommissionCashApply $cashApply, Collection $cashDetailList)
    {
        $this->storeId = $storeId;
        $this->cashDetailList = $cashDetailList;
        $this->merchantPayment = $merchantPayment;
        $this->cashApply = $cashApply;
        $this->transfer = app('wechat.payment.default')->transfer;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $error = '';
        try {
            /*待打款金额*/
            $amount = $this->cashApply->amount;
            $payAmount = $this->cashApply->pay_amount;
            $waitAmount = $this->cashApply->wait_amount;
            $transferAmount = 0;
            /*排除已打款的订单*/
            $this->cashDetailList->where('status', CommissionCashDetail::WAIT_STORE_PAY)
                ->map(function (CommissionCashDetail $cashDetail) use(&$error, &$amount, &$payAmount, &$waitAmount, &$transferAmount){
                    $error = "店铺没有配置证书";
                    $this->merchantPayment->amount = $cashDetail->amount;
                    $this->merchantPayment->partner_trade_no = $cashDetail->trade_no;
                    $result = $this->transfer->toBalance($this->merchantPayment->toArray());
                    $error = "微信打款失败(原因:本店铺金额不足,单人打款次数过多)";
                    if ($result['return_code'] == 'SUCCESS') {
                        $error = "{$result['return_msg']}详情请查看:https://pay.weixin.qq.com/wiki/doc/api/tools/mch_pay.php?chapter=14_2";
                        if ($result['result_code'] == "SUCCESS") {
                            /*剩余打款总金额*/
                            $transferAmount += $cashDetail->amount;
                            $date = time();
                            $update = [];
                            $update['status'] = 1;
                            $update['pay_amount'] = $cashDetail->pay_amount;
                            $update['wait_amount'] = 0;
                            $update['cash_time'] = $date;
                            $error = "数据更新失败";
                            CommissionCashDetail::where('cash_id', $cashDetail->commission_cash_apply_id)
                                ->update($update);
                            /*更新打款  APPLY与DETAIL 表*/
                            CommissionCashApply::whereId($cashDetail->commission_cash_apply_id)
                                ->where('status', CommissionCashApply::FRONT_SHOW_SUCCESS)
                                ->update([
                                    'pay_amount' => "pay_amount + {$cashDetail->amount}",
                                    'wait_amount' => "wait_amount - {$cashDetail->amount}"
                                ]);
                            /* 累计打款*/
                            $payAmount += $cashDetail->amount;
                            /* 剩余打款*/
                            $waitAmount = $amount - $payAmount;
                            /* 当前打款  $items['amount']*/
                            /* 微信 提现消息*/
                            $this->cashApply->user->miniProgramUser->notify(new CommissionExtractApply());
                        }
                    }
                    sleep(16);
                    if($transferAmount > 0){
                        $this->cashApply->user->update([
                            'total_cash_amount' => "total_cash_amount + {$transferAmount}",
                        ]);
                    }

                    /*等待打款的金额为0时,更新订单状态为已打款*/
                    if ($waitAmount == 0) {
                        $date = time();

                        $this->cashApply->update([
                            'status' => CommissionCashApply::PAY_SUCCESS,
                            'verify_time' => $date
                        ]);
                    }
                });
            return ;
        } catch(\Exception $e){
            $this->cashApply->update(['status' => 4, 'remark' => $e->getMessage()]);
        }
    }
}