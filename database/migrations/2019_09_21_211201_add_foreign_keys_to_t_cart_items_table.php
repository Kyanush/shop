<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTCartItemsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('cart_items', function(Blueprint $table)
		{
			$table->foreign('cart_id', 'cart_items_cart_id_foreign')->references('id')->on('t_carts')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('product_id', 'cart_items_product_id_foreign')->references('id')->on('t_products')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('cart_items', function(Blueprint $table)
		{
			$table->dropForeign('cart_items_cart_id_foreign');
			$table->dropForeign('cart_items_product_id_foreign');
		});
	}

}
