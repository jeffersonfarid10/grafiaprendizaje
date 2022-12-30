<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('section_question', function (Blueprint $table) {
            $table->id();
            //CAMPOS TABLA
            //LLAVES FORANEAS
            $table->unsignedBigInteger('section_id');
            $table->unsignedBigInteger('question_id');
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('section_question');
    }
};
