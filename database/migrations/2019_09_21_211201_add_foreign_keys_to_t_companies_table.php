<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTCompaniesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('companies', function(Blueprint $table)
		{
			$table->foreign('user_id', 'companies_user_id_foreign')->references('id')->on('t_users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('companies', function(Blueprint $table)
		{
			$table->dropForeign('companies_user_id_foreign');
		});
	}

}
