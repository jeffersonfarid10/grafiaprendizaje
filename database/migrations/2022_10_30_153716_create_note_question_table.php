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
        Schema::create('note_question', function (Blueprint $table) {
            $table->id();
            //CAMPOS TABLA
            //LLAVES FORANEAS
            $table->unsignedBigInteger('note_id');
            $table->unsignedBigInteger('question_id');
            $table->foreign('note_id')->references('id')->on('notes')->onDelete('cascade');
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
        Schema::dropIfExists('note_question');
    }
};
