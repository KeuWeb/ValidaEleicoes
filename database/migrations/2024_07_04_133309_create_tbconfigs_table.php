<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tbconfigs', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->id();
            $table->bigInteger('election');
            $table->integer('type')->default(1);
            $table->integer('form_aval')->default(1);
            $table->integer('form_local')->default(1);
            $table->integer('form_category')->default(2);
            $table->integer('rules_login_voter')->default(1);
            $table->integer('rules_voter_foreigner')->default(2);
            $table->integer('rules_time_vote')->nullable();
            $table->integer('rules_qtde_dif_votes')->nullable();
            $table->char('com_whatsapp',15)->nullable();
            $table->string('com_txt_whatsapp')->nullable();
            $table->text('com_first')->nullable();
            $table->text('com_end')->nullable();
            $table->text('com_message')->nullable();
            $table->timestamps();
        });

        DB::table('tbconfigs')->insert([
            'election' => 1,
            'type' => 1,
            'form_aval' => 1,
            'form_local' => 1,
            'form_category' => 2,
            'rules_login_voter' => 1,
            'rules_voter_foreigner' => 2,
            'rules_time_vote' => 600,
            'rules_qtde_dif_votes' => 10,
            'com_whatsapp' => null,
            'com_txt_whatsapp' => null,
            'com_first' => 'Seja bem vindo(a) Eleitor, através deste acesso você participará da Eleição informada. Duvidas entrar em contato com a Administração.',
            'com_end' => 'Voto computado com sucesso. Agradecemos pela participação em nossa Eleição.',
            'com_message' => 'Olá Eleitor, agradecemos por sua participação na Eleição. Seu voto foi computado com sucesso, abaixo segue maiores informações:'
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbconfigs');
    }
};
