<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAddonsToOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->integer('addon_estimated_price')->nullable();
        });

        Schema::table('order_item_images', function (Blueprint $table) {
            $table->integer('addon_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn('addon_estimated_price');
        });

        Schema::table('order_item_images', function (Blueprint $table) {
            $table->dropColumn('addon_id');
        });
    }
}
