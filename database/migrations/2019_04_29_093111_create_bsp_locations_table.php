<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBspLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bsp_locations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('city')->nullable();
            $table->integer('operator')->nullable();
            $table->integer('service')->nullable();
            $table->integer('bsp')->nullable();
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
        Schema::dropIfExists('bsp_locations');
    }
}
