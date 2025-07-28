<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orcamento_itens', function (Blueprint $table) {
            $table->id('id_orcamento_item');
            $table->decimal('valor_unitario', 10, 2);
            $table->integer('quantidade')->default(1);
            $table->unsignedBigInteger('id_orcamento');
            $table->foreign('id_orcamento')->references('id_orcamento')->on('orcamentos')->onDelete('cascade');
            $table->unsignedBigInteger('id_procedimento');
            $table->foreign('id_procedimento')->references('id_procedimento')->on('procedimentos')->onDelete('restrict');
        });
    }
    public function down(): void
    {

    }
};
