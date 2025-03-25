<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tbusers', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->id();
            $table->string('name',300);
            $table->string('email',300);
            $table->char('phone')->nullable();
            $table->char('login')->nullable();
            $table->string('password',300);
            $table->integer('level')->default(1);
            $table->string('token')->nullable();
            $table->timestamps();
            $table->integer('status')->default(1);
        });

        DB::table('tbusers')->insert([
            'name' => 'Administrador',
            'email' => 'adm@keu.tec.br',
            'phone' => null,
            'login' => 'keuweb',
            'password' => Hash::make('12345'),
            'level' => 1,
            'token' => null
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbusers');
    }
};
