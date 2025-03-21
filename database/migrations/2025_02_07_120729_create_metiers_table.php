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
        Schema::create('metiers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->char('cnae_code', 7)->unique();
            $table->timestamps();
        });



        Schema::table('companies', function (Blueprint $table) {
            $table->foreignId('metier_id')->after('currency_decimal_places')
            ->default(1) // Define o valor padrão como 1
            ->constrained('metiers', 'id')
            ->restrictOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remover a chave estrangeira antes de excluir a tabela
        Schema::table('companies', function (Blueprint $table) {
            $table->dropForeign(['metier_id']);
            $table->dropColumn('metier_id');
        });

        // Excluir a tabela metiers
        Schema::dropIfExists('metiers');
    }
};
