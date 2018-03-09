<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommissionCashApply extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        \Schema::create('commission_cash_apply', function (Blueprint $table){
            $table->increments('id');
            $table->unsignedInteger('store_id')->comment('店铺id');
            $table->unsignedInteger('distribution_member_id')->comment('分销商id');
            $table->unsignedInteger('distribution_user_id')->comment('分销商user id');
            $table->string('mobile', 11)->comment('电话');
            $table->string('name', 60)->comment('姓名');
            $table->unsignedInteger('apply_time')->comment('申请时间');
            $table->unsignedInteger('verify_time')->nullable()->default(null)->comment('审核时间');
            $table->float('amount', 12,4)->comment('申请金额');
            $table->float('pay_amount', 12, 4)->default(0)->comment('已经打款额度');
            $table->float('wait_amount', 12,4)->comment('等待打款金额');
            $table->string('remark')->nullable()->default(null)->comment('状态异常时备注');
            $table->unsignedTinyInteger('status')->default(0)->comment('状态 0待审核 1待打款 2已打款 3打款中 4打款失败');
            $table->timestamps();
            $table->softDeletes();

            $table->index('store_id');
            $table->index('distribution_member_id');
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
        \Schema::drop('commission_cash_apply');
    }
}
