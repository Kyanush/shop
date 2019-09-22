<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTProductsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('products', function(Blueprint $table)
		{
			$table->foreign('attribute_set_id', 'products_attribute_set_id_foreign')->references('id')->on('t_attribute_sets')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('group_id', 'products_group_id_foreign')->references('id')->on('t_product_groups')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('products', function(Blueprint $table)
		{
			$table->dropForeign('products_attribute_set_id_foreign');
			$table->dropForeign('products_group_id_foreign');
		});
	}

}
