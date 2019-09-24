<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTCategoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('categories', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('parent_id')->nullable()->default(0);
			$table->string('name', 100)->nullable();
			$table->string('url', 100)->nullable()->unique('unique_categories');
			$table->string('image', 100)->nullable();
			$table->string('class', 100)->nullable();
			$table->integer('sort')->nullable()->default(0);
			$table->string('type', 20)->nullable();
			$table->text('description', 65535)->nullable();
			$table->text('seo_keywords', 65535)->nullable();
			$table->text('seo_description', 65535)->nullable();
			$table->integer('active')->default(1);
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
		Schema::drop('t_categories');
	}

}
