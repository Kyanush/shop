<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTReviewLikesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('review_likes', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('like')->default(0);
			$table->string('visit_number')->nullable();
			$table->integer('review_id')->unsigned()->index('review_likes_review_id_foreign');
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
		Schema::drop('t_review_likes');
	}

}
