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
        Schema::create('tbcards', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->id();
            $table->integer('order');
            $table->char('title');
            $table->integer('limit_votes');
            $table->integer('limit_indicates');
            $table->bigInteger('category')->default(0);
            $table->bigInteger('local')->default(0);
            $table->timestamps();
            $table->integer('status_voting')->default(0);
            $table->integer('status')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbcards');
    }
};
