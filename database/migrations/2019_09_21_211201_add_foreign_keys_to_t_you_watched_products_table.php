<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTYouWatchedProductsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('you_watched_products', function(Blueprint $table)
		{
			$table->foreign('product_id', 'you_watched_products_product_id_foreign')->references('id')->on('t_products')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('you_watched_products', function(Blueprint $table)
		{
			$table->dropForeign('you_watched_products_product_id_foreign');
		});
	}

}
