<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTOrderStatusHistoryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('order_status_history', function(Blueprint $table)
		{
			$table->foreign('order_id', 'order_status_history_order_id_foreign')->references('id')->on('t_orders')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('status_id', 'order_status_history_status_id_foreign')->references('id')->on('t_order_statuses')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('user_id', 'order_status_history_user_id_foreign')->references('id')->on('t_users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('order_status_history', function(Blueprint $table)
		{
			$table->dropForeign('order_status_history_order_id_foreign');
			$table->dropForeign('order_status_history_status_id_foreign');
			$table->dropForeign('order_status_history_user_id_foreign');
		});
	}

}
