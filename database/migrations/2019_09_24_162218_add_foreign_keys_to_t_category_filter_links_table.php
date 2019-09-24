<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTCategoryFilterLinksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('category_filter_links', function(Blueprint $table)
		{
			$table->foreign('category_id', 'category_filter_links_category_id_foreign')->references('id')->on('t_categories')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('category_filter_links', function(Blueprint $table)
		{
			$table->dropForeign('category_filter_links_category_id_foreign');
		});
	}

}
