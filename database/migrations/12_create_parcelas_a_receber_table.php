<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('parcelas_a_receber', function (Blueprint $table) {
            $table->id('id_parcela');
            $table->string('descricao')->nullable();
            $table->decimal('valor', 10, 2);
            $table->date('data_vencimento');
            $table->enum('status', ['Pendente', 'Paga', 'Vencida', 'Cancelada'])->default('Pendente');
            $table->dateTime('data_pagamento')->nullable();
            $table->unsignedBigInteger('id_orcamento');
            $table->foreign('id_orcamento')->references('id_orcamento')->on('orcamentos')->onDelete('restrict');
        });
    }

    public function down(): void
    {

    }
};
