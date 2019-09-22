<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTProductAccessoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('product_accessories', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('accessory_product_id')->unsigned()->index('product_accessories_accessory_product_id_foreign');
			$table->integer('product_id')->unsigned()->index('product_accessories_product_id_foreign');
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
		Schema::drop('t_product_accessories');
	}

}
