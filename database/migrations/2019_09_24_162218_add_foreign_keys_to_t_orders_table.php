<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTOrdersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('orders', function(Blueprint $table)
		{
			$table->foreign('carrier_id', 'orders_carrier_id_foreign')->references('id')->on('t_carriers')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('payment_id', 'orders_payment_id_foreign')->references('id')->on('t_payments')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('status_id', 'orders_status_id_foreign')->references('id')->on('t_order_statuses')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('type_id', 'orders_type_id_foreign')->references('id')->on('t_statuses')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('user_id', 'orders_user_id_foreign')->references('id')->on('t_users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('orders', function(Blueprint $table)
		{
			$table->dropForeign('orders_carrier_id_foreign');
			$table->dropForeign('orders_payment_id_foreign');
			$table->dropForeign('orders_status_id_foreign');
			$table->dropForeign('orders_type_id_foreign');
			$table->dropForeign('orders_user_id_foreign');
		});
	}

}
