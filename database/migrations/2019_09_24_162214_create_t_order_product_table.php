<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTOrderProductTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('order_product', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('product_id')->unsigned()->index('order_product_product_id_foreign');
			$table->integer('order_id')->unsigned()->index('order_product_order_id_foreign');
			$table->string('name')->nullable();
			$table->string('sku', 100);
			$table->decimal('price', 13)->default(0.00);
			$table->decimal('cost_price', 13)->default(0.00)->comment('Себестоимость товара');
			$table->integer('quantity');
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
		Schema::drop('t_order_product');
	}

}
