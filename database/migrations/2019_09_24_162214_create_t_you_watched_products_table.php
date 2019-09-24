<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTYouWatchedProductsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('you_watched_products', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('visit_number');
			$table->integer('product_id')->unsigned()->index('you_watched_products_product_id_foreign');
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
		Schema::drop('t_you_watched_products');
	}

}
