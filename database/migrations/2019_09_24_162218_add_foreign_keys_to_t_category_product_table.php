<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTCategoryProductTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('category_product', function(Blueprint $table)
		{
			$table->foreign('category_id', 'category_product_category_id_foreign')->references('id')->on('t_categories')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('product_id', 'category_product_product_id_foreign')->references('id')->on('t_products')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('category_product', function(Blueprint $table)
		{
			$table->dropForeign('category_product_category_id_foreign');
			$table->dropForeign('category_product_product_id_foreign');
		});
	}

}
