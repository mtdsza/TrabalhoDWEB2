<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('estoque', function (Blueprint $table) {
            $table->id('id_item_estoque');
            $table->string('descricao', 255);
            $table->decimal('quantidade', 10, 3)->default(0.000);
            $table->decimal('estoque_min', 10, 3)->default(0.000);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('estoque');
    }
};
