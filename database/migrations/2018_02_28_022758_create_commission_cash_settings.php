<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommissionCashSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        \Schema::create('commission_cash_settings', function (Blueprint $table){
            $table->increments('id');
            $table->unsignedInteger('store_id')->comment('店铺ID');
            $table->float('min_cash_num', 12, 4)->nullable()->default(null)->comment('最低提现金额');
            $table->float('max_cash_num', 12, 4)->nullable()->default(null)->comment('最高提现金额');
            $table->timestamps();
            $table->softDeletes();
            $table->index('store_id');
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
        \Schema::drop('commission_cash_settings');
    }
}
