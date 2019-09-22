<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     * @table products
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->integer('group_id')->unsigned()->comment('Похожие товары');
            $table->foreign('group_id')
                ->references('id')->on('product_groups')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->integer('attribute_set_id')->unsigned()->comment('Наборы атрибутов');
            $table->foreign('attribute_set_id')
                ->references('id')->on('attribute_sets')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->string('name')->unique()->comment('Название');
            $table->string('url')->unique()->comment('Ссылка');
            $table->text('description')->nullable()->default(null)->comment('Описание');
            $table->text('description_mini')->nullable()->default(null)->comment('Краткое описание');

            $table->text('photo', 255)->nullable()->default(null)->comment('Фото товара');
            $table->integer('price')->default(0)->comment('Цена');
            $table->string('sku', 100);
            $table->integer('stock')->nullable()->default('0');
            $table->text('seo_keywords')->nullable()->default(null)->comment('SEO keywords');
            $table->text('seo_description')->nullable()->default(null)->comment('SEO description');
            $table->integer('active')->default(1)->comment('Активность');
            $table->string('youtube', 255)->nullable()->default(null)->comment('Youtube ссылка');
            $table->integer('view_count')->default(1)->comment('Количество просмотра');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
     public function down()
     {
       Schema::dropIfExists('products');
     }
}
