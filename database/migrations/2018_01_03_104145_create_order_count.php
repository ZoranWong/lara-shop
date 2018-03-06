<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderCount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        /**
         * `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
        `store_id` int(11) DEFAULT NULL COMMENT '商铺ID',
        `today_sum` float DEFAULT NULL COMMENT '今日销售金额',
        `yes_sales` float DEFAULT NULL COMMENT '昨日销售金额',
        `last_week_sales` float DEFAULT NULL COMMENT '前七天销售金额',
        `today_sales` int(11) DEFAULT NULL COMMENT '今日销量',
         * */
        Schema::create('order_count',function (Blueprint $table){
            $table->increments('id');
            $table->unsignedInteger('store_id')->comment('商铺ID');
            $table->string('store_code')->comment('店铺编号');
            $table->float('today_sum',10, 2)->comment('今日销售金额');
            $table->float('yes_sales',10, 2)->comment('昨日销售金额');
            $table->float('last_week_sales',10, 2)->comment('前七天销售金额');
            $table->unsignedInteger('today_sales')->comment('今日销量');
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
        Schema::drop('order_count');
    }
}
