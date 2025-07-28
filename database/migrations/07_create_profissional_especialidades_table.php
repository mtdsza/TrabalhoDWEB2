<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('profissional_especialidades', function (Blueprint $table) {
            $table->id('id_profissional_especialidade');
            $table->foreignId('id_profissional')->constrained('profissionais', 'id_profissional')->onDelete('cascade');
            $table->foreignId('id_especialidade')->constrained('especialidades', 'id_especialidade')->onDelete('cascade');
            $table->unique(['id_profissional', 'id_especialidade'], 'prof_espec_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profissional_especialidades');
    }
};
