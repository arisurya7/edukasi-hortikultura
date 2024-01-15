<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnPlantTypeInPlant extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('m_plants', function (Blueprint $table) {
            $table->foreignId('plant_type_id');
            $table->foreign('plant_type_id')->on('m_plant_type')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('m_plants', function (Blueprint $table) {
            $table->dropForeign('m_plant_plant_type_id_foreign');
        });
    }
}
