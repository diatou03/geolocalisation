<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
{
    Schema::disableForeignKeyConstraints();

    Schema::table('alertes', function (Blueprint $table) {
        $table->dropForeign(['pirogue_id']);
        $table->dropColumn('pirogue_id');
    });

    Schema::dropIfExists('pirogues');

    Schema::create('pirogues', function (Blueprint $table) {
        $table->id();
        $table->string('nom');
        $table->text('description')->nullable();
        $table->string('type');
        $table->date('date_creation')->nullable();
        $table->string('matricule')->nullable();
        $table->timestamps();
    });

    Schema::enableForeignKeyConstraints();
}

    public function down(): void {
        Schema::dropIfExists('pirogues');
    }
};
