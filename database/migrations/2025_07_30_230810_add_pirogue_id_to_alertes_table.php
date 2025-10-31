<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPirogueIdToAlertesTable extends Migration
{
    public function up()
{
    Schema::table('alertes', function (Blueprint $table) {
        Schema::disableForeignKeyConstraints();
        if (Schema::hasColumn('alertes', 'pirogue_id')) {
            $table->dropForeign(['pirogue_id']);
            $table->dropColumn('pirogue_id');
        }
        $table->unsignedBigInteger('pirogue_id')->nullable()->index();
        $table->foreign('pirogue_id')
              ->references('id')
              ->on('pirogues')
              ->onDelete('cascade');
        Schema::enableForeignKeyConstraints();
    });
}


    public function down()
    {
       Schema::table('alertes', function (Blueprint $table) {
    $table->dropForeign(['pirogue_id']);
    $table->dropColumn('pirogue_id');
     
     });
}
}