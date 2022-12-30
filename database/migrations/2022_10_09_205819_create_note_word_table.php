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
        Schema::create('note_word', function (Blueprint $table) {
            $table->id();
            //CAMPOS TABLA
            $table->unsignedBigInteger('note_id');
            $table->unsignedBigInteger('word_id');
            $table->foreign('note_id')->references('id')->on('notes')->onDelete('cascade');
            $table->foreign('word_id')->references('id')->on('words')->onDelete('cascade');

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
        Schema::dropIfExists('note_word');
    }
};
