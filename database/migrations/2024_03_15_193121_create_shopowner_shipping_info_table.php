<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shopowner_shipping_info', function (Blueprint $table) {
            $table->id();
            $table->string("user_id");
            $table->string("name");
            $table->string("email");
            $table->string("address");
            $table->string("country");
            $table->string("city");
            $table->string("state");
            $table->string("phone");
            $table->string("zipcode");
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
        Schema::dropIfExists('customerinfo');
    }
};
