<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('role')->default(1);
            $table->string('phone_number')->nullable();
            $table->boolean('phone_verified')->nullable();
            $table->timestamp('last_login')->nullable();
            $table->string('image')->nullable();
            $table->string('store_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('users', function (Blueprint $table) {
          $table->dropColumn('role');
          $table->dropColumn('phone_number');
          $table->dropColumn('phone_verified');
          $table->dropColumn('last_login');
          $table->dropColumn('image');
          $table->dropColumn('store_name');
      });
    }
}
