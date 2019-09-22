<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTSpecificPricesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('specific_prices', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('reduction')->nullable()->default(0);
			$table->string('discount_type', 20)->nullable();
			$table->dateTime('start_date')->nullable();
			$table->dateTime('expiration_date')->nullable();
			$table->integer('product_id')->unsigned()->nullable()->index('specific_prices_product_id_foreign');
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
		Schema::drop('t_specific_prices');
	}

}
