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
        Schema::create('tbelections', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->id();
            $table->string('type', 1)->nullable();
            $table->string('title')->nullable();
            $table->dateTime('date_initial')->nullable();
            $table->string('hour_initial')->nullable();
            $table->dateTime('date_end')->nullable();
            $table->string('hour_end')->nullable();
            $table->dateTime('date_invite')->nullable();
            $table->string('hour_invite')->nullable();
            $table->timestamps();
            $table->integer('status')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbelections');
    }
};
