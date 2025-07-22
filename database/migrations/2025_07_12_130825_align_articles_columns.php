<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlignArticlesColumns extends Migration
{
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            // nouvelle clé étrangère
           //  $table->unsignedBigInteger('categorie_id')->after('nom');
            $table->foreign('categorie_id')->references('id')->on('categories')->cascadeOnDelete();

            // stock
           // $table->integer('quantite')->default(0)->after('categorie_id');

            // prix
            //$table->decimal('prix_unitaire', 10, 2)->nullable()->after('quantite');
        });
    }

    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropForeign(['categorie_id']);
            $table->dropColumn(['categorie_id', 'quantite', 'prix_unitaire']);
        });
    }
}