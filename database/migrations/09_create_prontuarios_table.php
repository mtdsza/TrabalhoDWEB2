<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prontuarios', function (Blueprint $table) {
            $table->id('id_prontuario');
            $table->text('historico_odontologico')->nullable();
            $table->text('tratamentos_anteriores')->nullable();
            $table->text('diagnostico')->nullable();
            $table->text('prescricoes')->nullable();
            $table->text('observacoes')->nullable();
            $table->timestamp('data_registro')->useCurrent();
            $table->foreignId('id_paciente')->constrained('pacientes', 'id_paciente')->onDelete('cascade');
            $table->foreignId('id_profissional')->constrained('profissionais', 'id_profissional')->onDelete('restrict');
            $table->foreignId('id_consulta')->nullable()->constrained('consultas', 'id_consulta')->onDelete('set null');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('prontuarios');
    }
};
