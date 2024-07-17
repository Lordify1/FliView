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
        Schema::create('product', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->text("description");
            $table->foreignId("product_category_id");
            $table->foreignId("shop_id");
            $table->string("price");
            $table->string("how_many")->nullable();
            $table->foreignId("product_status_id");
            $table->string("sizes");
            $table->string("color");
            $table->string("admin_status");
            $table->timestamps();
        });
    }
    // ,["In Stock","Out Of Stock","Pre-order","Backorder","Discontinued","On Sale","New Arrival","Coming soon","Low stock","Unavailable"]
    // ["XS","S","M","L","XL"]
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product');
    }
};
