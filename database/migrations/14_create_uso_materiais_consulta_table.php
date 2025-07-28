<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('uso_materiais_consulta', function (Blueprint $table) {
            $table->id('id_uso_material');
            $table->decimal('quantidade', 10, 3);
            $table->timestamp('data_uso')->useCurrent();
            
            $table->unsignedBigInteger('id_consulta');
            $table->foreign('id_consulta')->references('id_consulta')->on('consultas')->onDelete('cascade');

            $table->unsignedBigInteger('id_item_estoque');
            $table->foreign('id_item_estoque')->references('id_item_estoque')->on('estoque')->onDelete('restrict');
        });
    }

    public function down(): void
    {

    }
};
