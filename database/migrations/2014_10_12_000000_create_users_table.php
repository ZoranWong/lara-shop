<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_persian_ci';
            $table->increments('id');
            $table->string('nickname', 124)->comment('用户昵称');
            $table->string('head_image_url',512)->nullable()->default(null)->comment('用户头像');
            $table->enum('sex',['MALE','FEMALE'])->comment('用户性别');
            $table->string('mobile')->unique()->comment('用户登录手机号码');
            $table->string('password')->comment('登录密码');
            $table->rememberToken()->comment('记住我token');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('token', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_persian_ci';
            $table->increments('id');
            $table->unsignedInteger('user_id')->comment('用户id');
            $table->string('token', 255)->unique()->comment('用户登录token');
            $table->integer('expire_in')->comment('token有效时间');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_id')->references('id')->on('user')
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
        Schema::dropIfExists('users');
        Schema::dropIfExists('token');
    }
}
