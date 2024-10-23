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
        Schema::create('tbassociation', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->id();
            $table->string('company',300)->nulllable();
            $table->char('cnpj')->nullable();
            $table->char('phone',15)->nullable();
            $table->string('email',300)->nullable();
            $table->char('responsible')->nullable();
            $table->char('cep',9)->nullable();
            $table->string('street')->nullable();
            $table->char('number')->nullable();
            $table->string('complement',255)->nullable();
            $table->string('neighborhood')->nullable();
            $table->string('city',150)->nullable();
            $table->char('uf',2)->nullable();
            $table->timestamps();
            $table->integer('status')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbassociation');
    }
};
