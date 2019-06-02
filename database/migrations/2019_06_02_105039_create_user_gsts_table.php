<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserGstsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_gsts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');

            $table->integer('cgst')->default(9);
            $table->integer('gst')->default(9);
            $table->integer('enabled')->default(1);
            
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
        Schema::dropIfExists('user_gsts');
    }
}
