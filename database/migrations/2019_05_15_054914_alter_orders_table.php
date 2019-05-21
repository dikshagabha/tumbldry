<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('cgst')->nullable();
            $table->string('gst')->nullable();
            $table->string('total_price')->nullable();  
            $table->string('coupon_id')->nullable(); 
            $table->string('coupon_discount')->nullable();
            //$table->integer('coupon_discount')->nullable();
            //$table->integer('coupon_discount')->nullable();          
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            //$table->dropColumn('estimated_price');
            $table->dropColumn('cgst');
            $table->dropColumn('gst');
            $table->dropColumn('total_price');  
            $table->dropColumn('coupon_id'); 
            $table->dropColumn('coupon_discount');
            //$table->integer('coupon_discount')->nullable();          
            
        });
    }
}
