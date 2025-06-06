<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create("users", function (Blueprint $table){
            $table->uuid("id")->primary();
            $table->string("username")->unique();
            $table->string("email");
            $table->string("password");
            $table->string("reg_ip");
            $table->date("last_login")->nullable();
            $table->string("last_ip")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
