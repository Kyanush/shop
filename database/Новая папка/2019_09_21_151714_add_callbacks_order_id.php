<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCallbacksOrderId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('callbacks', function($table) {
            $table->integer('order_id')->unsigned()->nullable();
            $table->foreign('order_id')
                ->references('id')->on('orders')
                ->onDelete('no action')
                ->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('callbacks', function($table) {
            $table->dropColumn('order_id');
        });
    }
}
