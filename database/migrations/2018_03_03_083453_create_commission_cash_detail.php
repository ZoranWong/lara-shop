<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommissionCashDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        \Schema::create('commission_cash_detail', function (Blueprint $table){
            $table->increments('id');
            $table->unsignedInteger('store_id')->comment('店铺id');
            $table->unsignedInteger('commission_cash_apply_id')->comment('申请单ID');
            $table->unsignedInteger('distribution_member_id')->comment('分销商id');
            $table->string('mobile', 11)->comment('电话');
            $table->string('name', 60)->comment('姓名');
            $table->unsignedInteger('apply_time')->comment('申请时间');
            $table->unsignedInteger('cash_time')->nullable()->default(null)->comment('审核时间');
            $table->float('amount', 12,4)->comment('申请金额');
            $table->float('pay_amount', 12, 4)->default(0)->comment('已经打款额度');
            $table->float('wait_amount', 12,4)->comment('等待打款金额');
            $table->string('remark')->nullable()->default(null)->comment('状态异常时备注');
            $table->unsignedTinyInteger('status')->default(0)->comment('状态 0待打款 1已打款 2打款中');
            $table->string('trade_no', 32)->nullable()->default(null)->comment('订单号(微信转账唯一凭证,
            打款失败再用此字段,避免重复打款)');
            $table->string('payment_no', 32)->nullable()->default(null)->comment('支付单号(微信支付 查询凭证)');
            $table->timestamps();
            $table->softDeletes();

            $table->index('store_id');
            $table->index('distribution_member_id');
            $table->unique('trade_no');
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
    }
}
