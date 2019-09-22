<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTCallbacksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('callbacks', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('phone')->nullable();
			$table->string('type')->nullable();
			$table->text('message', 65535)->nullable();
			$table->string('email')->nullable();
			$table->integer('status_id')->default(0)->index('callbacks_status_id_foreign_idx')->comment('Статус');
			$table->text('comment', 65535)->nullable()->comment('Комментарий администратора');
			$table->timestamps();
			$table->integer('order_id')->unsigned()->nullable()->index('callbacks_order_id_foreign');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('t_callbacks');
	}

}
