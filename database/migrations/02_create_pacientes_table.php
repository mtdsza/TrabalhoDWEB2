<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('pacientes', function (Blueprint $table) {
            $table->id('id_paciente');
            $table->string('nome', 255);
            $table->string('cpf', 11)->unique();
            $table->date('nascimento');
            $table->string('telefone', 13)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('endereco', 255)->nullable();
            $table->timestamps();
    });
}
    public function down(): void
    {
        Schema::dropIfExists('pacientes');
    }
};
