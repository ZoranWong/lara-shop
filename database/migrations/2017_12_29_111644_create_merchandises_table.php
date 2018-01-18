<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMerchandisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_persian_ci';
            $table->increments('id');
            $table->unsignedInteger('parent_id')->comment('父级分类ID');
            $table->string('name')->comment('分类名称');
            $table->tinyInteger('sort')->comment('分类排序');
            $table->boolean('is_default')->comment('是否默认分组，1未默认，0不为默认');
            $table->timestamps();
            $table->softDeletes();



        });

        Schema::create('specification', function (Blueprint $table){
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_persian_ci';
            $table->increments('id');
            $table->string('name', 64)->comment('规格名称');
            $table->text('value')->comment('JSON格式：{"红色":"红色"}');
            $table->enum('type', ['TEXT'])->comment('规格类型');
            $table->string('note')->comment('备注说明');
            $table->timestamps();
            $table->softDeletes();


        });

        Schema::create('merchandise', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_persian_ci';
            $table->increments('id');
            $table->unsignedInteger('store_id')->comment('店铺ID');
            $table->unsignedInteger('category_id')->comment('分类ID');
            $table->string('code', 50)->unique()->comment('商品编号');
            $table->string('name', 255)->comment('商品名称');
            $table->string('main_image_url', 255)->comment('主图url');
            $table->float('sell_price')->comment('售价');
            $table->float('prime_price')->comment('原价');
            $table->float('max_price')->comment('最大价格');
            $table->float('min_price')->comment('最小价格');
            $table->unsignedInteger('stock_num')->comment('库存');
            $table->unsignedInteger('sell_num')->comment('销售数量');
            $table->tinyInteger('sort')->comment('排序');
            $table->string('brief_introduction')->comment('简介');
            $table->text('content')->comment('商品详细内容');
            $table->text('spec_array')->comment('JSON存储规格数组,数组元素{name:"XX",id:"XX",value:{"XX":"XX"}}');
            $table->enum('status', ['ON','UNDER','SELL_OUT','DELETE'])->comment('货物状态:ON=上架，UNDER=下架');
            $table->timestamps();
            $table->softDeletes();


            $table->foreign('store_id')->references('id')->on('store')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('category')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('product', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_persian_ci';
            $table->increments('id');
            $table->unsignedInteger('merchandise_id')->comment('商品ID');
            $table->string('code', 50)->unique()->comment('规格产品编号');
            $table->text('spec_array')->comment('JSON存储规格数组,数组元素{name:"XX",id:"XX",value:"XX","tip":"XX"}');
            $table->float('sell_price')->comment('售价');
            $table->float('market_price')->comment('原价');
            $table->unsignedInteger('stock_num')->comment('库存');
            $table->timestamps();
            $table->softDeletes();


            $table->foreign('merchandise_id')->references('id')->on('merchandise')
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
        Schema::dropIfExists('category');
        Schema::dropIfExists('merchandise');
        Schema::dropIfExists('product');
    }
}
