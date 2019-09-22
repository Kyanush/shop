<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTReviewsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('reviews', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name')->nullable();
			$table->string('email')->nullable();
			$table->text('comment', 65535)->nullable();
			$table->text('plus', 65535)->nullable();
			$table->text('minus', 65535)->nullable();
			$table->integer('rating')->nullable();
			$table->integer('product_id')->unsigned()->nullable()->index('reviews_product_id_foreign');
			$table->timestamps();
			$table->integer('active')->nullable()->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('t_reviews');
	}

}
