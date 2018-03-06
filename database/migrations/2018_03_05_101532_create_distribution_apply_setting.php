<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDistributionApplySetting extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        \Schema::create('distribution_apply_setting', function (Blueprint $table){
            $table->increments('id');
            $table->unsignedInteger('store_id')->comment('店铺id');
            $table->unsignedTinyInteger('apply_type')->default(0)->comment('申请条件 0无条件 1指定商品 2满额');
            $table->unsignedTinyInteger('info_status')->default(0)->comment('申请时是否填写资料  0不填写  1填写');
            $table->unsignedTinyInteger('mobile_status')->default(0)->comment('是否发送手机号码  0不发送  1发送');
            $table->unsignedTinyInteger('check_way')->default(1)->comment('审核方式:1不需要审核 2需要审核');
            $table->unsignedTinyInteger('level')->default(0)->comment('分销最大等级');
            $table->unsignedTinyInteger('commission_days')->nullable->default(null)->comment('佣金结算天数');
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
        \Schema::drop('distribution_apply_setting');
    }
}
