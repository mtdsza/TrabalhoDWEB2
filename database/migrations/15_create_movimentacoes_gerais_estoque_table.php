<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('movimentacoes_gerais_estoque', function (Blueprint $table) {
            $table->id('id_movimentacao_geral');
            $table->decimal('quantidade', 10, 3);
            $table->enum('tipo', ['Entrada', 'Perda', 'Ajuste']);
            $table->string('justificativa')->nullable();
            $table->timestamp('data_movimentacao')->useCurrent();
            
            $table->unsignedBigInteger('id_item_estoque');
            $table->foreign('id_item_estoque')->references('id_item_estoque')->on('estoque')->onDelete('restrict');
        });
    }

    public function down(): void
    {

    }
};
