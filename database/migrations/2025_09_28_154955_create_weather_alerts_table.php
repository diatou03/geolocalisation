<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeatherAlertsTable extends Migration
{
    public function up()
    {
        Schema::create('weather_alerts', function (Blueprint $table) {
            $table->id();
            $table->string('title');          // Titre de l'alerte
            $table->text('description');     // Description détaillée
            $table->string('severity');       // Niveau de gravité (ex: 'warning', 'danger')
            $table->timestamp('alert_start'); // Début de l'alerte
            $table->timestamp('alert_end')->nullable(); // Fin de l'alerte (optionnel)
            $table->timestamps();             // created_at et updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('weather_alerts');
    }
}

