<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTAttributesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('attributes', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('type', 50)->nullable();
			$table->string('name', 100)->nullable();
			$table->integer('required')->nullable()->default(0);
			$table->string('code')->nullable();
			$table->integer('use_in_filter')->nullable()->default(0);
			$table->text('description', 65535)->nullable();
			$table->integer('attribute_group_id')->unsigned()->nullable()->index('attributes_attribute_group_id_foreign');
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
		Schema::drop('t_attributes');
	}

}
