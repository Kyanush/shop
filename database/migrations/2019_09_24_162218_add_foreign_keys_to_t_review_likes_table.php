<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTReviewLikesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('review_likes', function(Blueprint $table)
		{
			$table->foreign('review_id', 'review_likes_review_id_foreign')->references('id')->on('t_reviews')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('review_likes', function(Blueprint $table)
		{
			$table->dropForeign('review_likes_review_id_foreign');
		});
	}

}
