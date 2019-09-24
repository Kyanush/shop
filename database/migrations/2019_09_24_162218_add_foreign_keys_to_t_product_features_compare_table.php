<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTProductFeaturesCompareTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('product_features_compare', function(Blueprint $table)
		{
			$table->foreign('product_id', 'compare_products_product_id_foreign')->references('id')->on('t_products')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('product_features_compare', function(Blueprint $table)
		{
			$table->dropForeign('compare_products_product_id_foreign');
		});
	}

}
