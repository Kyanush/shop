<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTOrderStatusHistoryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('order_status_history', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('order_id')->unsigned()->index('order_status_history_order_id_foreign');
			$table->integer('status_id')->unsigned()->index('order_status_history_status_id_foreign');
			$table->timestamps();
			$table->integer('user_id')->unsigned()->index('order_status_history_user_id_foreign_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('t_order_status_history');
	}

}
