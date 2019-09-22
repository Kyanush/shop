<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderStatusesTable extends Migration
{
    /**
     * Run the migrations.
     * @table order_statuses
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_statuses', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name', 50)->nullable()->default(null);
            $table->integer('notification')->default(1);
            $table->text('description')->comment('Описание')->nullable()->default(null);
            $table->string('class', 25)->comment('Класс иконки')->nullable()->default(null);
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
       Schema::dropIfExists('order_statuses');
     }
}
