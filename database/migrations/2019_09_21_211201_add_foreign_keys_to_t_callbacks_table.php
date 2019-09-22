<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTCallbacksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('callbacks', function(Blueprint $table)
		{
			$table->foreign('order_id', 'callbacks_order_id_foreign')->references('id')->on('t_orders')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('status_id', 'callbacks_status_id_foreign')->references('id')->on('t_statuses')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('callbacks', function(Blueprint $table)
		{
			$table->dropForeign('callbacks_order_id_foreign');
			$table->dropForeign('callbacks_status_id_foreign');
		});
	}

}
