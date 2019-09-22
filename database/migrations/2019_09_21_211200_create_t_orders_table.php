<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTOrdersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('orders', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('type_id')->nullable()->default(1)->index('orders_type_id_foreign_idx');
			$table->integer('user_id')->unsigned()->index('orders_user_id_foreign');
			$table->integer('status_id')->unsigned()->index('orders_status_id_foreign');
			$table->integer('carrier_id')->unsigned()->nullable()->index('orders_carrier_id_foreign');
			$table->integer('shipping_address_id')->unsigned()->nullable()->index('orders_shipping_address_id_idx');
			$table->text('comment', 16777215)->nullable();
			$table->dateTime('delivery_date')->nullable();
			$table->decimal('total', 13)->nullable();
			$table->integer('payment_id')->unsigned()->nullable()->index('orders_payment_id_foreign')->comment('Тип оплаты');
			$table->integer('paid')->unsigned()->default(0);
			$table->dateTime('payment_date')->nullable();
			$table->text('payment_result', 65535)->nullable();
			$table->integer('where_ordered')->default(0)->comment('Где заказал');
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
		Schema::drop('t_orders');
	}

}
