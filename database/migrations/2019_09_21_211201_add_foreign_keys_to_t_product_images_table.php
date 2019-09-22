<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTProductImagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('product_images', function(Blueprint $table)
		{
			$table->foreign('product_id', 'product_images_product_id_foreign')->references('id')->on('t_products')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('product_images', function(Blueprint $table)
		{
			$table->dropForeign('product_images_product_id_foreign');
		});
	}

}
