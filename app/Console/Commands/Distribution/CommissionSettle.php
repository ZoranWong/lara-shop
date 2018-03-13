<?php

namespace App\Console\Commands\Distribution;

use App\Jobs\Distribution\MemberLevelUpgrade;
use App\Jobs\Distribution\SettleCommission;
use App\Models\Distribution\Member;
use App\Models\Distribution\Order;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;

class CommissionSettle extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'distribution:commissionSettle';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '分销提成自动结算';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        Order::where('status', Order::STATUS_UNSETTLED)->chunk(100, function (Collection $collection){
            $collection->map(function (Order $order){
                if($order->commission > 0 && $order->buyer && $order->buyer->distributionMember && $order->commission_status ===
                    Order::COMMISSION_STATUS_NORMAL){
                    $this->settleCommission($order->buyer->distributionMember, $order->commission, $order->payment_fee,
                        $order->store_id, $order->id);
                }

                if($order->father_commission > 0 && $order->distributionFather && $order->distributionFather->distributionMember &&
                    $order->father_commission_status === Order::COMMISSION_STATUS_NORMAL){
                    $this->settleCommission($order->distributionFather->distributionMember, $order->father_commission, $order->payment_fee,
                        $order->store_id, $order->id);
                }

                if($order->grand_father_commission > 0 && $order->distributionGrantFather && $order->distributionGrantFather->distributionMember
                    && $order->grand_father_commission_status === Order::COMMISSION_STATUS_NORMAL){
                    $this->settleCommission($order->distributionGrantFather->distributionMember, $order->grand_father_commission, $order->payment_fee,
                        $order->store_id, $order->id );
                }

                if($order->great_grand_father_commission > 0 && $order->distributionGreatGrantFather && $order->distributionGreatGrantFather
                        ->distributionMember && $order->great_grand_father_commission_status === Order::COMMISSION_STATUS_NORMAL){
                    $this->settleCommission($order->distributionGreatGrantFather->distributionMember, $order->great_grand_father_commission,
                        $order->payment_fee, $order->store_id, $order->id);
                }

                $order->commission_settle_status = Order::STATUS_SETTLED;
                $order->save();
            });
        });
        return true;
    }

    protected function settleCommission(Member $member, float $commission, float $paymentFee, int $storeId, int $orderId)
    {
        $member->amount += $commission;

        $member->total_commission_amount += $commission;

        $member->total_order_amount += $paymentFee;

        $member->total_wait_commission_amount += $commission;

        $result = $member->save();
        if($result){
            dispatch(new SettleCommission($member->user_id, date('Y-m-d h:m:s'), $storeId, $orderId, $commission));
            dispatch(new MemberLevelUpgrade($member));
        }
    }
}