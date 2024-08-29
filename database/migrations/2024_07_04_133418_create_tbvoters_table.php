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
        Schema::create('tbvoters', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->id();
            $table->string('name',300);
            $table->char('rg',15)->nullable();
            $table->char('cpf',15)->nullable();
            $table->char('other_doc',50)->nullable();
            $table->string('email',300)->nullable();
            $table->bigInteger('category')->nullable();
            $table->bigInteger('local')->nullable();
            $table->timestamps();
            $table->integer('status')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbvoters');
    }
};
