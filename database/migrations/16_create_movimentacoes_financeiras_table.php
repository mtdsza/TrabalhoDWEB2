<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('movimentacoes_financeiras', function (Blueprint $table) {
            $table->id('id_movimentacao_financeira');
            $table->string('descricao'); 
            $table->decimal('valor', 10, 2); 
            $table->enum('tipo', ['Entrada', 'Saida']); 
            $table->timestamp('data_movimentacao')->useCurrent(); 
            $table->unsignedBigInteger('id_consulta')->nullable(); 
            $table->foreign('id_consulta')->references('id_consulta')->on('consultas')->onDelete('set null');
            $table->unsignedBigInteger('id_orcamento')->nullable();
            $table->foreign('id_orcamento')->references('id_orcamento')->on('orcamentos')->onDelete('set null');
            $table->unsignedBigInteger('id_procedimento_realizado')->nullable();
            $table->foreign('id_procedimento_realizado')->references('id_procedimento_realizado')->on('procedimentos_realizados')->onDelete('set null');
            $table->unsignedBigInteger('id_parcela_paga')->nullable();
            $table->foreign('id_parcela_paga')->references('id_parcela')->on('parcelas_a_receber')->onDelete('set null');
        });
    }

    public function down(): void
    {

    }
};
