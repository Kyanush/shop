<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     * @table companies
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->integer('user_id')->unsigned()->comment('Пользователь ид');
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->string('name', 250)->nullable()->default(null)->comment('Нащвание');
            $table->string('address', 250)->nullable()->default(null)->comment('Адресь');
            $table->string('county', 250)->nullable()->default(null)->comment('Страна');
            $table->string('city', 250)->nullable()->default(null)->comment('Город');
            $table->text('info')->nullable()->default(null)->comment('Информация');

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
       Schema::dropIfExists('companies');
     }
}
