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
        // Schema::create('pirogues', function(Blueprint $table) {
    // $table->engine = 'InnoDB';
    //  $table->id();
        // $table->string('device_id')->index();
        // $table->decimal('latitude', 10, 7);
        // $table->decimal('longitude', 10, 7);
        // $table->timestamps();
// });

Schema::create('alertes', function(Blueprint $table) {
    $table->engine = 'InnoDB';
    $table->id();
    // Définition unique de pirogue_id avec clé étrangère et nullable si besoin
    $table->foreignId('pirogue_id')->nullable()->constrained('pirogues')->onDelete('cascade');
    $table->string('type')->nullable();
    $table->text('message');
    $table->decimal('latitude', 10, 7)>nullable();;
    $table->decimal('longitude', 10, 7)>nullable();;
    $table->boolean('envoyee')->default(false);
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alertes');
    }
};
