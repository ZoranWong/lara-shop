<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class EntrustSetupTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        // Create table for storing roles
        Schema::create('role', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_persian_ci';
            $table->increments('id');
            $table->string('name')->unique()->comment('角色唯一标示名称');
            $table->string('display_name')->nullable()->comment('角色显示名称');
            $table->string('description')->nullable()->comment('角色描述');
            $table->timestamps();
        });

        // Create table for associating roles to users (Many-to-Many)
        Schema::create('role_user', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_persian_ci';
            $table->integer('user_id')->unsigned()->comment('用户id');
            $table->integer('role_id')->unsigned('角色id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('user')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('role')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['user_id', 'role_id']);
        });

        // Create table for storing permissions
        Schema::create('permission', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_persian_ci';
            $table->increments('id');
            $table->integer('parent_id')->unsigned()->comment('权限id');
            $table->string('name')->unique()->comment('权限唯一名称标示');
            $table->string('display_name')->nullable()->comment('权限显示名称');
            $table->string('description')->nullable()->comment('权限描述');
            $table->timestamps();

            $table->foreign('parent_id')->references('id')->on('permission')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        // Create table for associating permissions to role (Many-to-Many)
        Schema::create('permission_role', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_persian_ci';
            $table->integer('permission_id')->unsigned()->comment('权限id');
            $table->integer('role_id')->unsigned()->comment('角色id');
            $table->timestamps();

            $table->foreign('permission_id')->references('id')->on('permission')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('role')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['permission_id', 'role_id']);
        });
        // Create table for associating permissions to user (Many-to-Many)
        Schema::create('permission_user', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_persian_ci';
            $table->integer('permission_id')->unsigned()->comment('权限id');
            $table->integer('user_id')->unsigned()->comment('用户id');
            $table->boolean('forbidden')->default(false)->commit('是否禁用');
            $table->timestamps();

            $table->foreign('permission_id')->references('id')->on('permission')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('user')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['permission_id', 'user_id']);
        });

        Schema::create('menu', function (Blueprint $table){
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_persian_ci';
            $table->increments('id');
            $table->unsignedInteger('parent_id')->default(null)->comment('父级菜单id');
            $table->integer('permission_id')->unsigned()->comment('权限id');
            $table->integer('parent_permission_id')->unsigned()->comment('父级权限id');
            $table->string('text', 64)->comment('菜单名称');
            $table->string('icon', 32)->comment('菜单图标');
            $table->string('url', 255)->comment('路由url');
            $table->boolean('is_active')->default(false)->comment('是否active');
            $table->boolean('visible')->default(true)->comment('是否visible');
            $table->tinyInteger('order')->default(0)->comment('排序');
            $table->timestamps();
            $table->foreign('parent_id')->references('id')->on('menu')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('permission_id')->references('id')->on('permission')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('parent_permission_id')->references('id')->on('permission')
                ->onUpdate('cascade')->onDelete('cascade');
            //$table->primary(['permission_id']);
        });

        Schema::create('endpoint', function (Blueprint $table){
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_persian_ci';
            $table->integer('permission_id')->unsigned()->comment('权限id');
            $table->string('name', 64)->comment('接口名称');
            $table->string('http_method', 8)->comment('http方法');
            $table->string('route_name', 255)->comment('路由名称');
            $table->string('$http_url_pattern', 255)->comment('路由url正则表达式');
            $table->string('params', 255)->comment('路由参数JSON格式');
            $table->boolean('disable')->default(false)->comment('是否无效');
            $table->timestamps();

            $table->foreign('permission_id')->references('id')->on('permission')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->primary(['permission_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        Schema::drop('permission_role');
        Schema::drop('permissions');
        Schema::drop('role_user');
        Schema::drop('roles');
        Schema::drop('permission_user');
        Schema::drop('menu');
        Schema::drop('endpoint');
    }
}
