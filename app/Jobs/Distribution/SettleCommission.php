<?php

namespace App\Jobs\Distribution;

use App\Models\User;
use App\Notifications\Wechat\CommissionSettlement;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SettleCommission implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $userId;
    //  结算时间
    public $date;

    public $storeId;
    //  订单号
    public $orderId;

    // 收益金额
    public $amount;

    protected $isRefund = false;


    /**
     * Create a new job instance.
     * @param int $userId
     * @param string $date
     * @param int $storeId
     * @param int $orderId
     * @param float $amount
     * @return void
     */
    public function __construct(int $userId, string $date, int $storeId, int $orderId, float $amount)
    {
        //
        $this->userId = $userId;
        $this->storeId = $storeId;
        $this->date = $date;
        $this->orderId = $orderId;
        $this->amount = $amount;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $user = User::find($this->userId);

        if($user){
            $user->notify(new CommissionSettlement($this->userId, $this->date, $this->storeId, $this->orderId, $this->amount));
        }
    }
}
