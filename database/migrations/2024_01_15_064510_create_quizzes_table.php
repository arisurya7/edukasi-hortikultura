<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuizzesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_quiz', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('quiz_type_id');
            $table->string('question');
            $table->boolean('answer');
            $table->foreign('quiz_type_id')->on('m_quiz_type')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('m_quiz', function (Blueprint $table) {
            $table->dropForeign('m_quiz_quiz_type_id_foreign');
        });
        
        Schema::dropIfExists('m_quiz');
    }
}
