<?php

namespace App\Jobs;

use App\Models\GroupCoupon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class GroupCouponOverDate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $id = null;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id)
    {
        //
        $this->id =$id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $groupCoupon = GroupCoupon::find($this->id);
        if($groupCoupon->end_time <= time()){
            $groupCoupon->status = GroupCoupon::STATUS['OVER_DATE'];
            $groupCoupon->save();
        }
    }
}
