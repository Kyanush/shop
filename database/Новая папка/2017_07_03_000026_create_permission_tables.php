<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePermissionTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {


        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->timestamps();
        });

        Schema::create('permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->timestamps();
        });

        Schema::create('permission_users', function (Blueprint $table){
            $table->integer('user_id')->unsigned();
            $table->integer('permission_id')->unsigned();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('permission_id')
                ->references('id')
                ->on('permissions')
                ->onDelete('cascade');

            $table->primary(['user_id', 'permission_id']);
        });

        Schema::create('role_users', function (Blueprint $table){
            $table->integer('role_id')->unsigned();
            $table->integer('user_id')->unsigned();

            $table->foreign('role_id')
                ->references('id')
                ->on('roles')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->primary(['role_id', 'user_id']);

            Schema::create('permission_roles', function (Blueprint $table){
                $table->integer('permission_id')->unsigned();
                $table->integer('role_id')->unsigned();

                $table->foreign('permission_id')
                    ->references('id')
                    ->on('permissions')
                    ->onDelete('cascade');

                $table->foreign('role_id')
                    ->references('id')
                    ->on('roles')
                    ->onDelete('cascade');

                $table->primary(['permission_id', 'role_id']);
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {


        Schema::drop('permission_roles');
        Schema::drop('role_users');
        Schema::drop('permission_users');
        Schema::drop('roles');
        Schema::drop('permissions');
    }
}
