<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable()->comment('Имя');
            $table->string('surname')->nullable()->comment('Фамилия');
            $table->string('email')->unique()->comment('Почта');

            $table->integer('role_id')->unsigned()->comment('Роль');
            $table->foreign('role_id')->references('id')->on('roles');

            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            $table->string('phone', 25)->nullable()->comment('Телефон');
            $table->tinyInteger('active')->default(1);

            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
