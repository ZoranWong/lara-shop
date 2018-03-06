<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderStaticsDaily extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        \Schema::create('order_statics_daily', function (Blueprint $table){
            $table->increments('id');
            $table->unsignedInteger('store_id')->comment('商铺ID');
            $table->float('today_amount',10, 2)->comment('今日销售金额');
            $table->unsignedInteger('today_sales')->comment('今日销量');
            $table->float('today_distribution_amount',10, 2)->comment('今日分销销售金额');
            $table->unsignedInteger('today_distribution_sales')->comment('今日分销订单量');
            $table->float('today_commission_amount',10, 2)->comment('今日分销佣金');
            $table->float('today_commission_paid_amount',10, 2)->comment('今日分销佣金已提现');
            $table->float('today_commission_apply_amount',10, 2)->comment('今日分销佣金待提现');
            $table->string('statics_date')->comment('统计日期');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        \Schema::drop('order_statics_daily');
    }
}
