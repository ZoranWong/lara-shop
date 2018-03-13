<?php

namespace App\Jobs\Distribution;

use App\Models\Distribution\CommissionLevel;
use App\Models\Distribution\Member;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class MemberLevelUpgrade implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $memberInfo;

    /**
     * Create a new job instance.
     * @param Member $member
     * @return void
     */
    public function __construct(Member $member)
    {
        $this->memberInfo  = $member;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()    {
        $availableLevel = CommissionLevel::where('store_id', $this->memberInfo->store_id)
            ->where('reach_amount','<=',$this->memberInfo->total_commission_amount)
            ->where('level','>',  $this->memberInfo->level->level)
            ->where('upgrade_type',  CommissionLevel::UPGRADE_AUTO)
            ->orderBy('level','DESC')
            ->first();
        if(!$availableLevel) {
            return ;
        }
        $this->memberInfo->level_id = $availableLevel->id;
        $this->memberInfo->save();
        $this->memberInfo->user->notify(new \App\Notifications\Wechat\MemberLevelUpgrade($this->memberInfo));
    }
}
