<?php

namespace App\Console\Commands\Order;

use Illuminate\Console\Command;

class Closed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:closed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '订单完成后一定时间后不能在退款';

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
    }
}
