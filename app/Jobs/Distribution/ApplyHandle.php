<?php

namespace App\Jobs\Distribution;

use App\Models\Distribution\Member;
use App\Notifications\Wechat\MemberApplyHandle;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ApplyHandle implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * @var Member
     * */
    protected $member = null;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Member $member)
    {
        //
        $this->member = $member;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        if($this->member && $this->member->user){
            $this->member->user->notify(new MemberApplyHandle($this->member));
        }
    }
}
