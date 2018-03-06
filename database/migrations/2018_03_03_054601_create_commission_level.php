<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommissionLevel extends Migration
{
    public function up()
    {
        //
        \Schema::create('commission_level', function (Blueprint $table){
            $table->increments('id');
            $table->unsignedInteger('store_id')->comment('店铺id');
            $table->string('name', 60)->comment('分销等级名称');
            $table->unsignedTinyInteger('commission_days')->default(1)->comment('佣金到账天数');
            $table->unsignedTinyInteger('level')->nullable()->default(null)->comment('分销层级');
            $table->unsignedTinyInteger('allocation')->default(0)->comment('分配方式：1-百分比 2-固定金额');
            $table->unsignedTinyInteger('commission_status')->default(0)->comment('自购佣金状态1开启0关闭');
            $table->unsignedTinyInteger('upgrade_type')->default(0)->comment('自动升级规则：0 不自动升级 1满额自动升级');
            $table->float('react_amount', 12, 4)->default(0)->comment('升级规则为1时，指定额度，单位：元');
            $table->float('commission', 12, 4)->default(0)->comment('自购佣金');
            $table->float('father_commission', 12, 4)->default(0)->comment('一级佣金');
            $table->float('grand_father_commission', 12, 4)->default(0)->comment('二级佣金');
            $table->float('great_grand_father_commission', 12, 4)->default(0)->comment('三级佣金');
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
        \Schema::drop('commission_level');
    }
}
