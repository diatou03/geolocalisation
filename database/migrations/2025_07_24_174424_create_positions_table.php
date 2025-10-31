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
        
 Schema::create('positions', function (Blueprint $table) {
        $table->id();
        $table->string('device_id');
        $table->decimal('latitude', 10, 6);
        $table->decimal('longitude', 10, 6);
        $table->decimal('altitude', 10, 2)->nullable();
        $table->decimal('speed', 10, 2)->nullable();
        $table->integer('satellites')->nullable();
        $table->timestamp('timestamp')->nullable();
        $table->timestamps();
    });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('positions');
    }
};
