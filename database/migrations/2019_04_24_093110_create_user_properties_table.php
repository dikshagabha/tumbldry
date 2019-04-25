<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserPropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_properties', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->string('property_type')->nullable();
            $table->string('store_size')->nullable();
            $table->string('store_rent')->nullable();
            $table->string('rent_enhacement')->nullable();
            $table->string('rent_enhacement_percent')->nullable();
            $table->string('landlord_name')->nullable();
            $table->string('landlord_number')->nullable();
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
        Schema::dropIfExists('user_properties');
    }
}
