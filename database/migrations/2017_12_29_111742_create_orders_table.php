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
            $table->string('code', 50)->unique()->comment('订单编码');
            $table->unsignedInteger('store_id')->comment('店铺ID');
            $table->unsignedInteger('buyer_user_id')->comment('购买者用户id');
            $table->unsignedInteger('num')->comment('商品数量');
            $table->float('total_fee')->comment('总价');
            $table->float('post_fee')->comment('邮费');
            $table->float('payment_fee')->comment('实付金额');
            $table->float('discount_fee')->comment('优惠金额');
            $table->string('receiver_name', 50)->comment('收货人姓名');
            $table->string('receiver_mobile', 50)->comment('收货人电话');
            $table->string('receiver_city', 50)->comment('收货人电话');
            $table->string('receiver_district', 50)->comment('收货人电话');
            $table->string('receiver_address', 50)->comment('收货人电话');
            $table->unsignedInteger('post_type')->comment('发货方式');
            $table->string('post_no', 50)->comment('运单号');
            $table->string('post_code', 50)->comment('收货地址邮政编码');
            $table->string('post_name', 50)->comment('快递名称');
            $table->enum('status', ['WAIT', 'CANCEL', 'PAID', 'SEND', 'COMPLETED', 'REFUND'])->comment('支付状态：WAIT 待支付 CANCEL 取消 PAID 完成支付 SEND 发货 COMPLETED  签收或者完成 REFUND 退款');
            $table->enum('cancel', ['BUYER', 'SELLER', 'AUTO'])->comment('取消人：BUYER 买家取消 SELLER 卖家取消 AUTO 自动取消');
            $table->enum('complete', ['BUYER', 'SELLER', 'AUTO'])->comment('取消人：BUYER 买家确认 SELLER 卖家确认 AUTO 自动确认');
            $table->enum('pay_type', ['WX_PAY', 'ALI_PAY', 'UNION_PAY', 'OTHER'])->default('WX_PAY')->comment('支付方式：WX_PAY 微信支付 ALI_PAY 支付宝支付 UNION_PAY 银联支付 OTHER 其他支付');
            $table->unsignedInteger('paid_at')->comment('支付时间');
            $table->unsignedInteger('completed_at')->comment('签收时间或者订单完成时间');
            $table->unsignedInteger('send_at')->comment('发货时间');
            $table->text('refund')->comment('退款 {refund_no:退款编码, total_fee: 订单总金额, refund_fee:退款金额}');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('store_id')->references('id')->on('store')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('buyer_user_id')->references('id')->on('user')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('order_item', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_persian_ci';
            $table->increments('id');
            $table->string('code', 50)->unique()->comment('订单编码');
            $table->unsignedInteger('order_id')->comment('商品ID');
            $table->unsignedInteger('store_id')->comment('店铺ID');
            $table->unsignedInteger('buyer_user_id')->comment('购买者用户id');
            $table->string('name', 255)->comment('商品标题作为此标题的值');
            $table->unsignedInteger('merchandise_id')->comment('商品ID');
            $table->string('merchandise_code', 50)->comment('商品货号');
            $table->unsignedInteger('product_id')->comment('规格产品ID');
            $table->string('merchandise_main_image_url')->comment('商品主图片缩略图地址');
            $table->string('sku_properties_name', 255)->comment('SKU的值，即：商品的规格 例如：颜色:黑色;尺码:XL;材料:毛绒XL');
            $table->float('total_fee')->comment('总价');
            $table->float('price')->comment('价格');
            $table->unsignedInteger('num')->comment('购买数量');
            $table->enum('status', ['WAIT', 'CANCEL', 'PAID', 'SEND', 'COMPLETED', 'REFUND'])->comment('支付状态：WAIT 待支付 CANCEL 取消 PAID 完成支付 SEND 发货 COMPLETED  签收或者完成 REFUND 退款');
            $table->enum('cancel', ['BUYER', 'SELLER', 'AUTO'])->comment('取消人：BUYER 买家取消 SELLER 卖家取消 AUTO 自动取消');
            $table->text('refund')->comment('退款 {refund_no:退款编码, total_fee: 订单总金额, refund_fee:退款金额}');
            $table->timestamps();
            $table->softDeletes();


            $table->foreign('store_id')->references('id')->on('store')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('buyer_user_id')->references('id')->on('user')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('merchandise_id')->references('id')->on('merchandise')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('product')
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
        Schema::dropIfExists('order');
        Schema::dropIfExists('order_item');
    }
}
