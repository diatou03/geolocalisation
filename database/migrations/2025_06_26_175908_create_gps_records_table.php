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
        Schema::create('gps_records', function (Blueprint $table) {
        $table->id();
        $table->string('device_id');
        $table->decimal('lat', 10, 6);
        $table->decimal('lon', 10, 6);
        $table->decimal('alt', 10, 2)->nullable();
         $table->timestamp('captured_at')->nullable();
        $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gps_records');
    }
};
