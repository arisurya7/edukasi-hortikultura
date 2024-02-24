<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPlantIdInMPlantDisease extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('m_plant_disease', function (Blueprint $table) {
            $table->foreignId('plant_id')->nullable();
            $table->foreign('plant_id')->on('m_plants')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('m_plant_disease', function (Blueprint $table) {
            $table->dropForeign('m_plant_disease_plant_id_foreign');
            $table->dropColumn('plant_id');
        });
    }
}
