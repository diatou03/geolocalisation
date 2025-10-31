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
        //  Création de la table parent `localisations`
        Schema::create('localisations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->string('nom');
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->timestamps();
        });

        //  Création de la table enfant `meteos`
        Schema::create('meteos', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();

            $table->unsignedBigInteger('localisation_id');
            $table->foreign('localisation_id')
                  ->references('id')
                  ->on('localisations')
                  ->onDelete('cascade');

            $table->float('temperature', 8, 2);
            $table->integer('humidite');
            $table->integer('pression');
            $table->float('vitesse_vent', 8, 2);
            $table->string('direction_vent');
            $table->string('ville');
            $table->timestamp('heure_prevision');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meteos');
        Schema::dropIfExists('localisations');
    }
};
