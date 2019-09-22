<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTProductAccessoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('product_accessories', function(Blueprint $table)
		{
			$table->foreign('accessory_product_id', 'product_accessories_accessory_product_id_foreign')->references('id')->on('t_products')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('product_id', 'product_accessories_product_id_foreign')->references('id')->on('t_products')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('product_accessories', function(Blueprint $table)
		{
			$table->dropForeign('product_accessories_accessory_product_id_foreign');
			$table->dropForeign('product_accessories_product_id_foreign');
		});
	}

}
