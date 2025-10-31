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
        Schema::create('weather_readings', function (Blueprint $table) {
    $table->id();
    $table->string('device_id');        // ex. 'heltec‑01'
    $table->string('city')->nullable(); // Dakar, Kaolack…
    $table->decimal('lat', 9, 6)->nullable();
    $table->decimal('lng', 9, 6)->nullable();
    $table->float('temperature');
    $table->integer('humidity');
    $table->string('description');
    $table->timestamp('captured_at');   // horodatage du capteur
    $table->timestamps();               // created_at / updated_at
    $table->index(['device_id', 'captured_at']);
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weather_readings');
    }
};
