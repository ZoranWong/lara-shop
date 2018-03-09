<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDistributionOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        \Schema::create('distribution_order', function (Blueprint $table){
            $table->increments('id');
            $table->unsignedInteger('store_id')->comment('店铺id');
            $table->unsignedInteger('order_id')->comment('订单ID');
            $table->unsignedInteger('order_item_id')->comment('订单子项ID');
            $table->unsignedInteger('buyer_user_id')->comment('购买者ID');
            $table->unsignedInteger('father_id')->nullable()->default(null)->comment('分销id');
            $table->unsignedInteger('grand_father_id')->nullable()->default(null)->comment('上上级代理id');
            $table->unsignedInteger('great_grand_father_id')->nullable()->default(null)->comment('grand_father_id父级代理id');
            $table->float('payment_fee', 12, 4)->nullable()->default(0)->comment('实付金额');
            $table->float('refund_fee', 12, 4)->nullable()->default(0)->comment('退款');
            $table->float('total_commission', 12, 4)->default(0)->comment('佣金总计');
            $table->float('commission', 12, 4)->default(0)->comment('自购佣金');
            $table->float('father_commission', 12, 4)->default(0)->comment('分销佣金');
            $table->float('grand_father_commission', 12, 4)->default(0)->comment('上上级分销佣金');
            $table->float('great_grand_father_commission', 12, 4)->default(0)->comment('grand_father上级分销佣金');
            $table->unsignedInteger('should_settled_at')->comment('应当结算时间');
            $table->unsignedInteger('real_settled_at')->nullable()->default(null)->comment('实际结算时间');
            $table->unsignedInteger('commission_status')->default(0)->comment('自购佣金状态:0正常 1冻结(不计入分销商佣金账户)');
            $table->unsignedInteger('father_commission_status')->default(0)->comment('直接分销商佣金状态:0正常 1冻结(不计入分销商佣金账户)');
            $table->unsignedInteger('grand_father_commission_status')->default(0)->comment('上级分销佣金状态:0正常 1冻结(不计入分销商佣金账户)');
            $table->unsignedInteger('great_grand_commission_status')->default(0)->comment('上上级分销商佣金状态:0正常 1冻结(不计入分销商佣金账户)');
            $table->unsignedInteger('commission_settle_status')->default(0)->comment('佣金结算状态 0未结算 1已结算2已退单');
            $table->enum('status', ['WAIT', 'CANCEL', 'PAID', 'SEND', 'COMPLETED'])
                ->nullable()->default('WAIT')
                ->comment('支付状态：WAIT 待支付 CANCEL 取消 PAID 完成支付 SEND 发货 COMPLETED  签收或者完成 REFUND 退款');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['store_id', 'commission_settle_status']);
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
        \Schema::drop('distribution_order');
    }
}
