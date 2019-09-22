<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTProductFeaturesWishlistTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('product_features_wishlist', function(Blueprint $table)
		{
			$table->foreign('product_id', 'product_features_wishlist_product_id_foreign')->references('id')->on('t_products')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('user_id', 'product_features_wishlist_user_id_foreign')->references('id')->on('t_users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('product_features_wishlist', function(Blueprint $table)
		{
			$table->dropForeign('product_features_wishlist_product_id_foreign');
			$table->dropForeign('product_features_wishlist_user_id_foreign');
		});
	}

}
