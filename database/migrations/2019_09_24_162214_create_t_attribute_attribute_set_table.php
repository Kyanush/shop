<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTAttributeAttributeSetTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('attribute_attribute_set', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('attribute_id')->unsigned()->index('attribute_attribute_set_attribute_id_foreign');
			$table->integer('attribute_set_id')->unsigned()->index('attribute_attribute_set_attribute_set_id_foreign');
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
		Schema::drop('t_attribute_attribute_set');
	}

}
