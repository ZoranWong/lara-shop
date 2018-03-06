<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_persian_ci';
            $table->increments('id');
            $table->string('code', 32)->unique()->comment('订单编码');
            $table->unsignedInteger('buyer_user_id')->comment('购买者用户id');
            $table->unsignedInteger('num')->comment('商品数量');
            $table->string('form_id', 50)->comment('预支付订单ID');
            $table->string('name', 255)->comment('商品标题作为此标题的值');
            $table->float('total_fee')->comment('总价');
            $table->float('post_fee')->default(0)->comment('邮费');
            $table->float('payment_fee')->comment('实付金额');
            $table->float('discount_fee')->default(0)->comment('优惠金额');
            $table->string('receiver_name', 50)->nullable()->default(null)->comment('收货人姓名');
            $table->string('receiver_mobile', 11)->nullable()->default(null)->comment('收货人电话');
            $table->string('receiver_city', 50)->nullable()->default(null)->comment('收货人电话');
            $table->string('receiver_district', 50)->nullable()->default(null)->comment('收货人电话');
            $table->string('receiver_address', 256)->nullable()->default(null)->comment('收货人电话');
            $table->enum('post_type', ['NONE', 'SF', 'YUNDA', 'YTO', 'STO', 'ZTO',
                'BEST', 'TTK', 'EMS'])
                ->nullable()
                ->default(null)->comment('发货方式');
            $table->string('post_no', 50)->nullable()->default(null)->comment('运单号');
            $table->string('post_code', 50)->nullable()->default(null)->comment('收货地址邮政编码');
            $table->string('post_name', 50)->nullable()->default(null)->comment('快递名称');
            $table->enum('status', ['WAIT', 'CANCEL', 'PAID', 'SEND', 'COMPLETED'])->nullable()->default(null)->comment('支付状态：WAIT 待支付 CANCEL 取消 PAID 完成支付 SEND 发货 COMPLETED  签收或者完成');
            $table->enum('cancel', ['BUYER', 'SELLER', 'AUTO'])->nullable()->default(null)->comment('取消人：BUYER 买家取消 SELLER 卖家取消 AUTO 自动取消');
            $table->enum('complete', ['BUYER', 'SELLER', 'AUTO'])->nullable()->default(null)->comment('取消人：BUYER 买家确认 SELLER 卖家确认 AUTO 自动确认');
            $table->enum('pay_type', ['WX_PAY', 'ALI_PAY', 'UNION_PAY', 'OTHER'])->nullable()->default('WX_PAY')->comment('支付方式：WX_PAY 微信支付 ALI_PAY 支付宝支付 UNION_PAY 银联支付 OTHER 其他支付');
            $table->unsignedInteger('paid_at')->nullable()->default(null)->comment('支付时间');
            $table->unsignedInteger('completed_at')->nullable()->default(null)->comment('签收时间或者订单完成时间');
            $table->unsignedInteger('send_at')->nullable()->default(null)->comment('发货时间');
            $table->string('error_code', 30)->nullable()->default(null)->comment('错误码');
            $table->boolean('closed')->default(false)->comment('订单是否关闭关闭后不能坐其他操作');
            $table->enum('fee_type', ['CNY', 'USD', 'TWD', 'HKD',
                'JPY', 'AUD', 'CAD', 'FKP', 'MOP', 'NZD', 'GBP', 'EUR', 'SGD',
                'VND', 'TRY', 'THB', 'SEK', 'MXN', 'NOK', 'CHF', 'CZK', 'DKK',
                'DJK', 'EGP', 'COP', 'HUF', 'IDR'])
                ->nullable()->default('CNY')->comment('支付币种');
            $table->timestamps();
            $table->softDeletes();

        });

        Schema::create('order_item', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_persian_ci';
            $table->increments('id');
            $table->string('code', 32)->unique()->comment('订单编码');
            $table->unsignedInteger('order_id')->comment('商品ID');
            $table->string('order_code', '32')->comment('订单编号');
            $table->unsignedInteger('store_id')->comment('店铺ID');
            $table->string('store_code', 32)->comment('店铺编号');
            $table->unsignedInteger('buyer_user_id')->comment('购买者用户id');
            $table->string('name', 255)->comment('商品标题作为此标题的值');
            $table->unsignedInteger('merchandise_id')->comment('商品IDphp');
            $table->string('merchandise_code', 32)->comment('商品货号');
            $table->unsignedInteger('product_id')->nullable()->comment('规格产品ID');
            $table->string('product_code', 32)->nullable()->comment('产品编号');
            $table->string('merchandise_main_image_url')->nullable()->default(null)->comment('商品主图片缩略图地址');
            $table->string('sku_properties_name', 255)->nullable()->default(null)->comment('SKU的值，即：商品的规格 例如：颜色:黑色;尺码:XL;材料:毛绒XL');
            $table->float('total_fee')->comment('总价');
            $table->boolean('closed')->default(false)->comment('订单是否关闭关闭后不能坐其他操作');
            $table->float('post_fee')->nullable()->default(0)->comment('邮费');
            $table->float('price')->comment('价格');
            $table->unsignedInteger('num')->default(1)->comment('购买数量');
            $table->enum('status', ['WAIT', 'CANCEL', 'PAID', 'SEND', 'COMPLETED'])
                ->nullable()->default('WAIT')
                ->comment('支付状态：WAIT 待支付 CANCEL 取消 PAID 完成支付 SEND 发货 COMPLETED  签收或者完成 REFUND 退款');
            $table->enum('cancel', ['BUYER', 'SELLER', 'AUTO'])->nullable()
                ->default(null)->comment('取消人：BUYER 买家取消 SELLER 卖家取消 AUTO 自动取消');
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order');
        Schema::dropIfExists('order_item');
    }
}
