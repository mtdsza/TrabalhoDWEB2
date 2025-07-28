<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('consultas', function (Blueprint $table) {
            $table->id('id_consulta');
            $table->dateTime('data_inicio');
            $table->dateTime('data_fim')->nullable();
            $table->text('descricao')->nullable();
            $table->enum('situacao', ['Agendada', 'Realizada', 'Cancelada'])->default('Agendada');
            $table->foreignId('id_paciente')->constrained('pacientes', 'id_paciente')->onDelete('restrict');
            $table->foreignId('id_profissional')->constrained('profissionais', 'id_profissional')->onDelete('restrict');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('consultas');
    }
};
