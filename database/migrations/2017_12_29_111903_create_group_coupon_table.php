<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupCouponTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_coupon', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_persian_ci';
            $table->increments('id');
            $table->string('code', 32)->unique()->comment('团购编号');
            $table->unsignedInteger('store_id')->comment('店铺ID');
            $table->string('store_code', 32)->comment('店铺code');
            $table->unsignedInteger('merchandise_id')->comment('产品id');
            $table->string('merchandise_code', 32)->comment('产品id');
            $table->string('name', 255)->comment('团购活动名称');
            $table->unsignedInteger('start_time')->comment('开始时间');
            $table->unsignedInteger('end_time')->comment('结束时间');
            $table->enum('status', ['WAIT', 'RUNNING', 'OVER_DATE', 'INVALID'])
                ->comment('团购状态：WAIT 未开始 RUNNING 进行中 OVER_DATE 结束 INVALID 失效');
            $table->tinyInteger('member_num')->default(2)->comment('团购人数');
            $table->tinyInteger('buy_limit_num')->default(0)->comment('购买限制 等于0时不受限制');
            $table->boolean('auto_patch')->default(true)->comment('自动拼团');
            $table->boolean('leader_prefer')->default(false)->comment('团长优惠是否开启');
            $table->float('leader_price')->default(0)->comment('团长优惠价格');
            $table->text('products_array')->nullable()->comment('sku团购配置：[{"id":"709","price":"100", "leader_price": "90"}]');
            $table->float('price')->comment('团购价格');
            $table->float('min_price')->default(0)->comment('团购最小价格');
            $table->float('max_price')->default(0)->comment('团购最大价格');
            $table->float('min_leader_price')->default(0)->comment('团长优惠价格最小价格');
            $table->float('max_leader_price')->default(0)->comment('团长优惠价格最大价格');
            $table->string('mini_program_code')->comment('小程序二维码');
            $table->timestamps();
            $table->softDeletes();

            
            $table->foreign('store_id')->references('id')->on('store')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('merchandise_id')->references('id')->on('merchandise')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->index('code');
            $table->index('merchandise_code');
            $table->index('store_code');
        });

        Schema::create('group', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_persian_ci';
            $table->increments('id');
            $table->string('code', 32)->unique()->comment('团购团编号');
            $table->unsignedInteger('store_id')->comment('店铺id');
            $table->string('store_code', 32)->comment('店铺编号');
            $table->unsignedInteger('leader_user_id')->comment('团长用户id');
            $table->unsignedInteger('group_coupon_id')->comment('团购活动ID');
            $table->string('group_coupon_code', 32)->comment('团购活动编号');
            $table->unsignedInteger('remaining_num')->comment('拼团剩余人数');
            $table->unsignedInteger('opened_at')->default(null)->comment('开团时间');
            $table->unsignedInteger('auto_cancel_at')->default(null)->comment('未成团时自动取消拼团时间');
            $table->unsignedInteger('patched_at')->default(null)->comment('完成拼团时间');
            $table->enum('status', ['OPENING', 'PATCHING', 'FULL', 'PATCHED', 'OVER_DATE', 'INVALID', 'CANCEL'])
                ->nullable()
                ->default(null)
                ->comment('拼团状态:OPENING 开团待付款 PATCHING 拼团中 FULL 满员待成员付款 PATCHED 完成拼团 OVER_DATE 团购过期 INVALID 团购失效 CANCEL 拼团关闭');
            $table->enum('cancel', ['AUTO_CANCEL', 'BUYER_REFUND', 'SELLER_CANCEL'])
                ->nullable()
                ->default(null)
                ->comment('关闭状态：AUTO_CANCEL 拼团过期 BUYER_REFUND 买家退款 SELLER_CANCEL 卖家主动取消拼团');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('store_id')->references('id')->on('store')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('group_coupon_id')->references('id')->on('group_coupon')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('leader_user_id')->references('id')->on('user')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->index('code');
            $table->index('store_code');
            $table->index('group_coupon_code');
        });

        Schema::create('group_order', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_persian_ci';
            $table->increments('id');
            $table->string('code', 32)->unique()->comment('团购订单编号');
            $table->unsignedInteger('buyer_user_id')->comment('团长用户id');
            $table->unsignedInteger('store_id')->comment('店铺id');
            $table->string('store_code', 32)->comment('店铺编号');
            $table->unsignedInteger('group_coupon_id')->comment('团购活动ID');
            $table->string('group_coupon_code', 32)->comment('团购活动编号');
            $table->unsignedInteger('group_id')->comment('拼团ID');
            $table->string('group_code', 32)->comment('团购团编号');
            $table->unsignedInteger('order_id')->comment('订单id');
            $table->string('order_code', 32)->comment('订单编号');
            $table->unsignedInteger('opened_at')->default(null)->comment('参团时间');
            $table->unsignedInteger('auto_cancel_at')->comment('未成团时自动取消拼团时间');
            $table->enum('status', ['WAIT_PAY', 'PATCHING',  'PATCHED', 'OVER_DATE', 'INVALID', 'CANCEL', 'SEND', 'COMPLETE'])
                ->nullable()
                ->default('WAIT_PAY')
                ->comment('拼团状态:OPENING 开团待付款 PATCHING 拼团中 FULL 满员待成员付款 PATCHED 完成拼团 OVER_DATE 团购过期 INVALID 团购失效 CANCEL 拼团关闭 SEND 发货 COMPLETE 签收或者完成');
            $table->enum('cancel', ['AUTO_CANCEL', 'BUYER_REFUND', 'SELLER_CANCEL'])
                ->nullable()
                ->default(null)
                ->comment('关闭状态：AUTO_CANCEL 拼团过期 BUYER_REFUND 买家退款 SELLER_CANCEL 卖家主动取消拼团');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('store_id')->references('id')->on('store')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('group_coupon_id')->references('id')->on('group_coupon')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('leader_user_id')->references('id')->on('user')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('group_id')->references('id')->on('group')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('order_id')->references('id')->on('order')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->index('code');
            $table->index('store_code');
            $table->index('group_coupon_code');
            $table->index('group_code');
            $table->index('order_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('group_coupon');
        Schema::dropIfExists('group');
        Schema::dropIfExists('group_order');
    }
}
