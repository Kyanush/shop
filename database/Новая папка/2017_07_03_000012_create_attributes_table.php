<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttributesTable extends Migration
{
    /**
     * Run the migrations.
     * @table attributes
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attributes', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('type', 50)->comment('Тип');
            $table->string('name', 100)->comment('Название');
            $table->integer('required')->default(0)->comment('Обязательные поля');
            $table->string('code', 255)->nullable()->default(null)->comment('Символьный код');
            $table->integer('use_in_filter')->default(0)->comment('Показывать в фильтре');
            $table->text('description')->nullable()->default(null)->comment('Символьный код');

            $table->integer('attribute_group_id')->unsigned()->nullable();
            $table->foreign('attribute_group_id')->references('id')->on('attribute_groups');

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
       Schema::dropIfExists('attributes');
     }
}
