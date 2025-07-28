<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('procedimentos_realizados', function (Blueprint $table) {
            $table->id('id_procedimento_realizado');
            $table->integer('quantidade')->default(1);
            $table->decimal('valor_cobrado', 10, 2);
            $table->text('descricao')->nullable();
            $table->string('anexo', 512)->nullable();
            $table->unsignedBigInteger('id_consulta');
            $table->foreign('id_consulta')->references('id_consulta')->on('consultas')->onDelete('restrict');
            $table->unsignedBigInteger('id_procedimento');
            $table->foreign('id_procedimento')->references('id_procedimento')->on('procedimentos')->onDelete('restrict');
            $table->unsignedBigInteger('id_orcamento_item')->nullable();
            $table->foreign('id_orcamento_item')->references('id_orcamento_item')->on('orcamento_itens')->onDelete('set null');
        });
    }

    public function down(): void
    {
        
    }
};
