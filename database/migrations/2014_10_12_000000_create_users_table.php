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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->date('dob');
            $table->string('phone');
            $table->foreignId('state_id');
            $table->foreignId('lga_id');
            $table->string("user_type");
            $table->enum("gender",["male","female"]);
            $table->text("dp");
            $table->string("status");
            $table->string("email_verified_at");
            $table->string("verification_token");
            $table->string("expiry_time");
            $table->timestamp("last_login");
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
