<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTAttributeValuesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('attribute_values', function(Blueprint $table)
		{
			$table->foreign('attribute_id', 'attribute_values_attribute_id_foreign')->references('id')->on('t_attributes')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('attribute_values', function(Blueprint $table)
		{
			$table->dropForeign('attribute_values_attribute_id_foreign');
		});
	}

}
