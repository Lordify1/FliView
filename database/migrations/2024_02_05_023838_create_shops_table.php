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
        Schema::create('shops', function (Blueprint $table) {
            $table->id();
            $table->string("shop_name");
            $table->text("shop_description");
            $table->text("shop_address");
            $table->string("shop_phone");
            $table->string("opening_time");
            $table->string("closing_time");
            $table->text("shop_logo");
            $table->string("shop_email");
            $table->foreignId("user_id");
            $table->string("payment_method");
            // $table->string("payment_currency");
            $table->string("status");
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
        Schema::dropIfExists('shops');
    }
};
