<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTAttributeProductValueTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('attribute_product_value', function(Blueprint $table)
		{
			$table->foreign('attribute_id', 'attribute_product_value_attribute_id_foreign')->references('id')->on('t_attributes')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('product_id', 'attribute_product_value_product_id_foreign')->references('id')->on('t_products')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('attribute_product_value', function(Blueprint $table)
		{
			$table->dropForeign('attribute_product_value_attribute_id_foreign');
			$table->dropForeign('attribute_product_value_product_id_foreign');
		});
	}

}
