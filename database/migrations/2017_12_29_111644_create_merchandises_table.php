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
            $table->unsignedInteger('parent_id')->nullable()->default(null)->comment('父级分类ID');
            $table->string('name')->comment('分类名称');
            $table->tinyInteger('sort')->default(0)->comment('分类排序');
            $table->boolean('is_default')->default(1)->comment('是否默认分组，1未默认，0不为默认');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('specification', function (Blueprint $table){
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_persian_ci';
            $table->increments('id');
            $table->string('name', 64)->comment('规格名称');
            $table->text('value')->nullable()->comment('JSON格式：{"红色":"红色"}');
            $table->enum('type', ['TEXT'])->default('TEXT')->comment('规格类型');
            $table->string('note')->nullable()->default(null)->comment('备注说明');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('merchandise', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_persian_ci';
            $table->increments('id');
            $table->unsignedInteger('store_id')->comment('店铺ID');
            $table->string('store_code', 32)->comment('店铺ID');
            $table->unsignedInteger('category_id')->comment('分类ID');
            $table->string('code', 32)->unique()->comment('商品编号');
            $table->string('name', 255)->comment('商品名称');
            $table->string('main_image_url', 512)->nullable()->default(null)->comment('主图url');
            $table->float('sell_price')->default(0)->comment('售价');
            $table->float('market_price')->default(0)->comment('原价');
            $table->float('max_price')->default(0)->comment('最大价格');
            $table->float('min_price')->default(0)->comment('最小价格');
            $table->unsignedInteger('stock_num')->default(0)->comment('库存');
            $table->unsignedInteger('sell_num')->default(0)->comment('销售数量');
            $table->tinyInteger('sort')->default(0)->comment('排序');
            $table->string('brief_introduction')->nullable()->default(null)->comment('简介');
            $table->text('content')->nullable()->comment('商品详细内容');
            $table->text('images')->nullable()->commet('图片数组');
            $table->text('spec_array')->nullable()->comment('JSON存储规格数组,数组元素{name:"XX",id:"XX",value:{"XX":"XX"}}');
            $table->enum('status', ['SELL_OUT','ON_SHELVES','TAKEN_OFF'])->default('ON_SHELVES')->comment('货物状态:ON_SHELVES=上架，TAKEN_OFF=下架');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('store_id')->references('id')->on('store')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('category')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->index('category_id');
            $table->index('store_id');
            $table->index('code');
            $table->index('store_code');
        });

        Schema::create('product', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_persian_ci';
            $table->increments('id');
            $table->unsignedInteger('merchandise_id')->comment('商品ID');
            $table->string('merchandise_code', 32)->comment('商品编码');
            $table->string('code', 32)->unique()->comment('规格产品编号');
            $table->text('spec_array')->nullable()->comment('JSON存储规格数组,数组元素{name:"XX",id:"XX",value:"XX","tip":"XX"}');
            $table->float('sell_price')->default(0)->comment('售价');
            $table->float('market_price')->default(0)->comment('原价');
            $table->unsignedInteger('stock_num')->default(0)->comment('库存');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('merchandise_id')->references('id')->on('merchandise')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->index('merchandise_id');
            $table->index('merchandise_code');
            $table->index('code');
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
