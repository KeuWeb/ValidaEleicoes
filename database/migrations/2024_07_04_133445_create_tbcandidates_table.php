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
        Schema::create('tbcandidates', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->id();
            $table->integer('type')->default(1);
            $table->string('name',300);
            $table->bigInteger('category');
            $table->bigInteger('local');
            $table->bigInteger('card');
            $table->integer('photo')->nullable();
            $table->text('curriculum')->nullable();
            $table->text('obs')->nullable();
            $table->bigInteger('votes_indication')->default(0);
            $table->bigInteger('votes_election')->default(0);
            $table->timestamps();
            $table->integer('status')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbcandidates');
    }
};
