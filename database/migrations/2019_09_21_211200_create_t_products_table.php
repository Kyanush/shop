<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTProductsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('products', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('group_id')->unsigned()->nullable()->index('products_group_id_foreign');
			$table->integer('attribute_set_id')->unsigned()->nullable()->index('products_attribute_set_id_foreign');
			$table->string('name')->nullable();
			$table->string('url')->nullable()->comment('Ссылка товара');
			$table->text('description')->nullable();
			$table->text('description_mini', 65535)->nullable();
			$table->string('photo')->nullable();
			$table->integer('price')->nullable();
			$table->string('sku', 100)->nullable();
			$table->integer('stock')->nullable()->default(0);
			$table->integer('viewed')->nullable()->default(0);
			$table->text('seo_keywords', 65535)->nullable();
			$table->text('seo_description', 65535)->nullable();
			$table->timestamps();
			$table->integer('active')->nullable()->default(1);
			$table->string('youtube', 20)->nullable();
			$table->integer('view_count')->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('t_products');
	}

}
