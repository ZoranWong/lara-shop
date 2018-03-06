<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShoppingCart extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('shopping_cart', function (Blueprint $table){
            $table->increments('id');
            $table->string('code', 20)->comment('购物车编号');
            $table->unsignedInteger('store_id')->comment('店铺id');
            $table->string('store_code', 20)->comment('店铺code');
            $table->unsignedInteger('buyer_user_id')->comment('购买者id');
            $table->unsignedInteger('merchandise_id')->comment('商品id');
            $table->string('merchandise_code', 20)->comment('商品code');
            $table->unsignedInteger('product_id')->nullable()->comment('规格商品id');
            $table->string('product_code', 20)->nullable()->comment('规格商品code');
            $table->string('name', 50)->comment('商品名称');
            $table->string('merchandise_main_image_url', 255)->nullable()->default(null)->comment('商品图片');
            $table->string('sku_properties_name')->nullable()->default(null)->comment('SKU的值，即：商品的规格 例如：颜色:黑色;尺码:XL;材料:毛绒XL');
            $table->float('total_fee')->comment('总价');
            $table->float('price')->comment('单价');
            $table->unsignedInteger('num')->comment('商品数量');
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
        //
        Schema::drop('shopping_cart');
    }
}
