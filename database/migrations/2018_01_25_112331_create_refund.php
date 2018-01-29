<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRefund extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        \Schema::create('refund', function (Blueprint $table){
            $table->increments('id');
            $table->string('code', 20)->comment('订单子项编号');
            $table->unsignedInteger('order_id')->comment('订单id');
            $table->string('order_code', 20)->comment('订单编号');
            $table->unsignedInteger('store_id')->comment('店铺id');
            $table->string('store_code', 20)->comment('店铺编号');
            $table->unsignedInteger('buyer_user_id')->comment('买家id');
            $table->unsignedInteger('merchandise_id')->comment('商品id');
            $table->string('merchandise_code', 20)->comment('产品编号');
            $table->unsignedInteger('product_id')->nullable()->comment('产品id');
            $table->string('product_code', 20)->nullable()->comment('产品编号');
            $table->unsignedInteger('order_item_id')->comment('订单子项id');
            $table->string('order_item_code', 20)->comment('订单子项编号');
            $table->string('refund_reason', 512)->nullable()->default(null)->comment('退款理由');
            $table->string('refuse_reason', 512)->nullable()->default(null)->comment('拒绝理由');
            $table->boolean('refund_product')->default(false)->comment('是否退货');
            $table->float('total_fee')->comment('订单总额');
            $table->float('refund_fee')->comment('退款金额');
            $table->enum('status', ['REFUNDING','REFUNDED','REFUSED','CLOSED'])->nullable()->default(null)->comment('退款状态');
            $table->enum('fee_type', ['CNY', 'USD', 'TWD', 'HKD',
                'JPY', 'AUD', 'CAD', 'FKP', 'MOP', 'NZD', 'GBP', 'EUR', 'SGD',
                'VND', 'TRY', 'THB', 'SEK', 'MXN', 'NOK', 'CHF', 'CZK', 'DKK',
                'DJK', 'EGP', 'COP', 'HUF', 'IDR'])->default('CNY')->comment('退款货币');
            $table->enum('refund_account', ['REFUND_SOURCE_UNSETTLED_FUNDS',
                'REFUND_SOURCE_RECHARGE_FUNDS'])->default('REFUND_SOURCE_RECHARGE_FUNDS')
                ->comment('退款资金来源');
            $table->float('settlement_refund_fee')->default(0)->comment('应结退款金额');
            $table->float('settlement_total_fee')->default(0)->comment('应结订单金额');
            $table->float('cash_fee')->default(0)->comment('现金支付金额');
            $table->float('cash_refund_fee')->default(0)->comment('现金退款金额');

            $table->enum('cash_fee_type', ['CNY', 'USD', 'TWD', 'HKD',
                'JPY', 'AUD', 'CAD', 'FKP', 'MOP', 'NZD', 'GBP', 'EUR', 'SGD',
                'VND', 'TRY', 'THB', 'SEK', 'MXN', 'NOK', 'CHF', 'CZK', 'DKK',
                'DJK', 'EGP', 'COP', 'HUF', 'IDR'])->default('CNY')->comment('现金支付币种');
            $table->string('error_code', 30)->nullable()->default(null)->comment('错误码');
            $table->enum('coupon_type', ['CASH', 'NO_CASH'])->default('CASH')->comment('代金券类型');

            $table->float('coupon_refund_fee')->default(0)->comment('代金券退款总金额');
            $table->text('coupon_refund')->nullable()->comment('代金券退款{id:XX,fee:XX}');
            $table->integer('coupon_refund_count')->default(0)->comment('退款代金券使用数量');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('store_id')->references('id')->on('store')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('buyer_user_id')->references('id')->on('user')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('merchandise_id')->references('id')->on('merchandise')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('order_id')->references('id')->on('order')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('product_id')->references('id')->on('product')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('order_item_id')->references('id')->on('order_item')
                ->onUpdate('cascade')->onDelete('cascade');
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
        Schema::drop('refund');
    }
}
