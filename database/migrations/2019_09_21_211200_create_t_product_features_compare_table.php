<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTProductFeaturesCompareTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('product_features_compare', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('visit_number')->nullable();
			$table->integer('product_id')->unsigned()->index('compare_products_product_id_foreign');
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
		Schema::drop('t_product_features_compare');
	}

}
