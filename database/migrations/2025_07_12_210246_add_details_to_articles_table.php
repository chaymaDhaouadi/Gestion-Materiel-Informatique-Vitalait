<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDetailsToArticlesTable extends Migration
{
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->string('image')->nullable()->after('reference');
            $table->text('description_courte')->nullable()->after('nom');
            $table->string('numero_serie')->nullable()->after('categorie_id');
            $table->string('modele')->nullable()->after('numero_serie');
            $table->string('marque')->nullable()->after('modele');
        });
    }

    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropUnique(['numero_serie']);
            $table->dropColumn([
                'image', 'description_courte',
                'numero_serie', 'modele', 'marque'
            ]);
        });
    }
}
