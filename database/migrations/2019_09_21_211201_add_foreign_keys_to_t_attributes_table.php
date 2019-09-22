<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTAttributesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('attributes', function(Blueprint $table)
		{
			$table->foreign('attribute_group_id', 'attributes_attribute_group_id_foreign')->references('id')->on('t_attribute_groups')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('attributes', function(Blueprint $table)
		{
			$table->dropForeign('attributes_attribute_group_id_foreign');
		});
	}

}
