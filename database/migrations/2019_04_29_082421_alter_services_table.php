<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('services', function (Blueprint $table) {
            $table->integer('form_type')->default(1);
        });

         Schema::table('service_prices', function (Blueprint $table) {
            $table->integer('quantity')->nullable()->default(1);
            $table->integer('bsp')->nullable()->default(0);
            $table->string('location')->nullable()->default(0);
            $table->integer('service_type')->nullable()->default(0);
            $table->integer('operator')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::table('services', function (Blueprint $table) {
            $table->dropColumn('form_type');
        });

          Schema::table('service_prices', function (Blueprint $table) {
            $table->dropColumn('quantity');
        });
    }
}
