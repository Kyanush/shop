<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTStatusesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('statuses', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('name');
			$table->string('class');
			$table->string('where_use', 20);
			$table->integer('default')->default(0);
			$table->integer('sort')->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('t_statuses');
	}

}
