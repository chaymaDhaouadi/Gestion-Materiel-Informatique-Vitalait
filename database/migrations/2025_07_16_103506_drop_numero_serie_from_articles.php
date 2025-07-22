<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            // ⬇️ SUPPRIME la colonne
            $table->dropColumn('numero_serie');
            // 👉 si tu veux aussi supprimer "quantite", ajoute :
            // $table->dropColumn('quantite');
        });
    }

    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            // ⬇️ REMET la colonne si on fait un rollback
            $table->string('numero_serie')->nullable();
            // $table->unsignedInteger('quantite')->default(0);  // si tu l’as supprimée
        });
    }
};
