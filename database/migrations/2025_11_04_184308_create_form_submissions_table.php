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
        Schema::create('form_submissions', function (Blueprint $table) {
            $table->id();

            $table->string('nome');
            $table->string('email')->unique();
            $table->string('telefone')->nullable();
            $table->date('nascimento')->nullable();
            $table->string('sexo')->nullable();
            $table->string('estado')->nullable();
            $table->string('cidade')->nullable();
            $table->string('curso')->nullable();
            $table->string('linkedin')->nullable();

            // ALTERAÇÃO 1: Mudado de string (255 chars) para text (para suportar textos longos)
            $table->text('sobre')->nullable();

            $table->string('selected_area');

            // JSON é perfeito para user_answers, certifique-se que seu banco é MySQL 5.7+ ou MariaDB 10.2+
            $table->json('user_answers');

            $table->integer('score_total');
            $table->integer('score_facil');

            // ALTERAÇÃO 2: Mudado de score_media para score_medio para bater com o export do Excel em web.php
            $table->integer('score_medio');

            $table->integer('score_dificil');
            $table->string('calculated_level');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_submissions');
    }
};
