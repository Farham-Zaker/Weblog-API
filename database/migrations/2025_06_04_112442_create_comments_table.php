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
        Schema::create('comments', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->string("comment")->nullable(false);
            $table->timestamps();

            $table->uuid("user_id");
            $table->unsignedBigInteger("article_id");
            $table->foreign("user_id")->references("id")->on("users");
            $table->foreign("article_id")->references("id")->on("articles");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
