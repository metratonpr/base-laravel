<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('municipality_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->string('razao_social');
            $table->string('nome_fantasia')->nullable();
            $table->char('cnpj', 14)->unique();
            $table->string('ie', 15);
            $table->string('im', 15)->nullable();
            $table->char('crt', 1);
            $table->string('logradouro');
            $table->string('numero', 20);
            $table->string('complemento', 80)->nullable();
            $table->string('bairro', 120);
            $table->char('cep', 8);
            $table->string('phone', 20)->nullable();
            $table->string('email')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
