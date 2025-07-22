<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            // Si la colonne a un index/unique, on le retire d’abord
            if (Schema::hasColumn('articles', 'numero_serie')) {
                // Laravel supprime l'index automatiquement quand on drop la colonne
                $table->dropColumn('numero_serie');
            }
            // Idem pour 'quantite' si tu veux l’enlever :
            // if (Schema::hasColumn('articles', 'quantite')) {
            //     $table->dropColumn('quantite');
            // }
        });
    }

    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->string('numero_serie')->nullable();
            // $table->unsignedInteger('quantite')->default(0);
        });
    }
};
