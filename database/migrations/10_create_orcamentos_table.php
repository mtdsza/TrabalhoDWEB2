<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orcamentos', function (Blueprint $table) {
            $table->id('id_orcamento');
            $table->date('data_emissao');
            $table->date('data_validade')->nullable();
            $table->decimal('valor_total', 10, 2)->default(0.00);
            $table->unsignedBigInteger('id_paciente');
            $table->foreign('id_paciente')->references('id_paciente')->on('pacientes')->onDelete('cascade');
            $table->unsignedBigInteger('id_profissional');
            $table->foreign('id_profissional')->references('id_profissional')->on('profissionais')->onDelete('restrict');
            $table->unsignedBigInteger('id_consulta')->nullable();
            $table->foreign('id_consulta')->references('id_consulta')->on('consultas')->onDelete('set null');
        });
    }

    public function down(): void
    {
        //
    }
};
