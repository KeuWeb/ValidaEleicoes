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
        Schema::create('tbvotings', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->id();
            $table->string('type')->nullable();
            $table->bigInteger('card');
            $table->bigInteger('candidate');
            $table->bigInteger('voter');
            $table->string('code')->nullable();
            $table->timestamps();
            $table->text('log_info')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbvotings');
    }
};
