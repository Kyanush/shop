<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     * @table categories
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('parent_id')->nullable()->default(0)->comment('Родитель ид');
            $table->string('name', 100)->nullable()->default(null)->comment('Название');
            $table->string('url')->unique()->comment('Ссылка');
            $table->string('image', 100)->nullable()->default(null)->comment('Фото');
            $table->string('class', 100)->nullable()->default(null)->comment('Класс');
            $table->integer('sort')->nullable()->default(0)->comment('Сортировка');
            $table->string('type', 20)->nullable()->default(null)->comment('Тип');
            $table->text('description')->nullable()->default(null)->comment('Описание');
            $table->text('seo_keywords')->nullable()->default(null)->comment('SEO keywords');
            $table->text('seo_description')->nullable()->default(null)->comment('SEO description');
            $table->integer('active')->nullable()->default(1)->comment('Активность');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
     public function down()
     {
       Schema::dropIfExists('categories');
     }
}
