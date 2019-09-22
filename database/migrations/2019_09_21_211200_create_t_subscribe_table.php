<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTSubscribeTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('subscribe', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('email');
			$table->integer('product_id')->unsigned()->nullable()->index('subscribe_product_id_foreign');
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
		Schema::drop('t_subscribe');
	}

}
