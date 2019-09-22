<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTAttributeAttributeSetTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('attribute_attribute_set', function(Blueprint $table)
		{
			$table->foreign('attribute_id', 'attribute_attribute_set_attribute_id_foreign')->references('id')->on('t_attributes')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('attribute_set_id', 'attribute_attribute_set_attribute_set_id_foreign')->references('id')->on('t_attribute_sets')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('attribute_attribute_set', function(Blueprint $table)
		{
			$table->dropForeign('attribute_attribute_set_attribute_id_foreign');
			$table->dropForeign('attribute_attribute_set_attribute_set_id_foreign');
		});
	}

}
