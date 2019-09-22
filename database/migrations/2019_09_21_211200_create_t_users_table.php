<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('surname')->nullable();
			$table->string('email');
			$table->integer('role_id');
			$table->dateTime('email_verified_at')->nullable();
			$table->string('password');
			$table->string('remember_token', 100)->nullable();
			$table->timestamps();
			$table->string('phone', 25)->nullable()->comment('Телефон');
			$table->integer('active')->nullable()->default(1);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('t_users');
	}

}
