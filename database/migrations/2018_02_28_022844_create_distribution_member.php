<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDistributionMember extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        \Schema::create('distribution_member', function (Blueprint $table){
            $table->increments('id');
            $table->unsignedInteger('store_id')->comment('代理的店铺id');
            $table->unsignedInteger('user_id')->comment('代理的用户id');
            $table->unsignedInteger('level_id')->comment('等级id');
            $table->unsignedInteger('father_id')->nullable()->default(null)->comment('上级代理id');
            $table->unsignedInteger('grand_father_id')->nullable()->default(null)->comment('上上级代理id');
            $table->unsignedInteger('great_grand_father_id')->nullable()->default(null)->comment('grand_father_id父级代理id');
            $table->unsignedInteger('depth')->default(1)->comment('深度');
            $table->string('path')->nullable()->default(null)->comment('路径：user id 用,隔开');
            $table->float('amount', 12, 4)->default(0)->comment('账户佣金余额');
            $table->float('total_order_amount', 12, 4)->default(0)->comment('分销订单金额总计');
            $table->float('total_paid_commission_amount', 12, 4)->default(0)->comment('已结算分销佣金总计');
            $table->float('total_wait_commission_amount', 12, 4)->default(0)->comment('待结算分销佣金总计');
            $table->unsignedInteger('total_subordinate_num')->default(0)->comment('下级分销商数量');
            $table->unsignedInteger('total_cash_amount')->default(0)->comment('提现佣金总计');
            $table->unsignedInteger('apply_time')->comment('申请时间');
            $table->unsignedInteger('join_time')->nullable()->default(null)->comment('加入或者审核时间');
            $table->unsignedTinyInteger('apply_status')->default(0)->comment('申请状态0:未申请  1:待审核 2：通过 3拒绝');
            $table->boolean('is_active')->default(1)->comment('冻结状态 1:开启 0关闭');
            $table->unsignedInteger('referrals')->default(0)->comment('下级人数(不限级数统计)');
            $table->string('full_name', 60)->nullable()->default(null)->comment('姓名');
            $table->string('mobile', 11)->nullable()->default(null)->comment('电话');
            $table->string('wechat')->nullable()->default(null)->comment('微信号');
            $table->timestamps();
            $table->softDeletes();

            $table->index('store_id');

            $table->index('user_id');
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
        \Schema::drop('distribution_member');
    }
}
