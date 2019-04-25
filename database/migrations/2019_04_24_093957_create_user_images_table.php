<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_images', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->string('address_proof')->nullable();
            $table->string('gst_certificate')->nullable();
            $table->string('bank_passbook')->nullable();
            $table->string('cheque')->nullable();
            $table->string('pan')->nullable();
            $table->string('id_proof')->nullable();
            $table->string('loi_copy')->nullable();
            $table->string('transaction_details')->nullable();
            $table->string('agreement_copy')->nullable();
            $table->string('rent_agreement')->nullable();
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
        Schema::dropIfExists('user_images');
    }
}
