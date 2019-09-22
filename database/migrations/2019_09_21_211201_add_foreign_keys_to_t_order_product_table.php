<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTOrderProductTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('order_product', function(Blueprint $table)
		{
			$table->foreign('order_id', 'order_product_order_id_foreign')->references('id')->on('t_orders')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('product_id', 'order_product_product_id_foreign')->references('id')->on('t_products')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('order_product', function(Blueprint $table)
		{
			$table->dropForeign('order_product_order_id_foreign');
			$table->dropForeign('order_product_product_id_foreign');
		});
	}

}
