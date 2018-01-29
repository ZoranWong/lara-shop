<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_persian_ci';
            $table->increments('id');
            $table->string('code', 32)->unique()->comment('店铺编号');
            $table->string('name', 32)->comment('店铺名称');
            $table->string('logo_url')->default(null)->comment('店铺logo图片');
            $table->float('amount', 12, 2)->default(0)->comment('店铺余额');
            $table->string('wechat', 20)->nullable()->comment('联系人微信');
            $table->string('qq', 20)->nullable()->comment('联系人qq');
            $table->enum('status',['APPLY', 'PASS', 'REFUSE'])->default('APPLY')->commit('店铺状态');
            $table->timestamps();
            $table->softDeletes();

            $table->index('code');
        });

        Schema::create('store_owner', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_persian_ci';
            $table->unsignedInteger('store_id')->comment('店铺id');
            $table->unsignedInteger('user_id')->comment('店铺拥有者用户id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('store_id')->references('id')->on('store')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('user')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['store_id', 'user_id']);
        });

        Schema::create('store_manager', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_persian_ci';
            $table->unsignedInteger('store_id')->comment('店铺id');
            $table->unsignedInteger('user_id')->comment('店铺管理者用户id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('store_id')->references('id')->on('store')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('user')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['store_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('store');
        Schema::dropIfExists('store_owner');
        Schema::dropIfExists('store_manager');
    }
}
