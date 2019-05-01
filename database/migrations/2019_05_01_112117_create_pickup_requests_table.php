<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePickupRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pickup_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('customer_id');
            $table->integer('store_id');
            $table->integer('status')->default(1)->nullable();
            $table->integer('address')->nullable();
             $table->integer('request_mode')->default(1);

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
        Schema::dropIfExists('pickup_requests');
    }
}
