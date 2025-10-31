<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('pirogues', function (Blueprint $table) {
            // Vérifie si la colonne n'existe pas avant de l'ajouter
            if (!Schema::hasColumn('pirogues', 'matricule')) {
                $table->string('matricule')->nullable()->after('device_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('pirogues', function (Blueprint $table) {
            // Supprime la colonne uniquement si elle existe
            if (Schema::hasColumn('pirogues', 'matricule')) {
                $table->dropColumn('matricule');
            }
        });
    }
};

