<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profissionais', function (Blueprint $table) {
            $table->id('id_profissional');
            $table->string('nome', 255);
            $table->string('email', 255)->unique();
            $table->string('telefone', 13)->nullable();
            $table->string('cro', 15);
            $table->boolean('ativo')->default(true);
            $table->date('data_contratacao')->nullable();
            $table->decimal('salario_base', 10, 2)->nullable();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('profissionais');
    }
};
