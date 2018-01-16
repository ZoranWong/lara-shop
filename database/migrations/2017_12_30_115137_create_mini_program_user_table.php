<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMiniProgramUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mini_program_user', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_persian_ci';
            $table->unsignedInteger('user_id')->comment('小程序登录普通用户id');
            $table->string('open_id', 64)->comment('微信登录open_id');
            $table->string('union_id', 64)->comment('微信多平台用户三方登录唯一标识');
            $table->string('session_key')->comment('微信登录session');
            $table->unsignedInteger('expire_in')->comment('微信登录session过期时间');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('user')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mini_program_user');
    }
}
