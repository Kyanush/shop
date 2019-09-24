<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTOrdersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('orders', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('type_id')->index('orders_type_id_foreign_idx')->comment('Тип заказа');
			$table->integer('user_id')->unsigned()->nullable()->index('orders_user_id_foreign')->comment('Пользователь');
			$table->integer('status_id')->unsigned()->index('orders_status_id_foreign')->comment('Текущее состояние');
			$table->integer('carrier_id')->unsigned()->nullable()->index('orders_carrier_id_foreign')->comment('Курьер');
			$table->text('comment', 16777215)->nullable()->comment('Комментарии');
			$table->dateTime('delivery_date')->nullable()->comment('Дата доставки');
			$table->decimal('total', 13)->nullable()->comment('Сумма');
			$table->integer('payment_id')->unsigned()->nullable()->index('orders_payment_id_foreign')->comment('Тип оплаты');
			$table->integer('paid')->unsigned()->default(0)->comment('Оплачено');
			$table->dateTime('payment_date')->nullable()->comment('Дата оплаты');
			$table->text('payment_result', 65535)->nullable()->comment('Результат оплаты');
			$table->integer('where_ordered')->default(0)->comment('Где заказал');
			$table->string('address')->nullable()->comment('Адрес');
			$table->string('city')->nullable()->comment('Город');
			$table->string('user_name')->nullable()->comment('Имя пользователя');
			$table->string('user_phone', 25)->nullable()->comment('Телефон пользователя');
			$table->string('user_email')->nullable()->comment('Почта пользователя');
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
		Schema::drop('t_orders');
	}

}
