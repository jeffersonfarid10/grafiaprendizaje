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
        Schema::create('rule_question', function (Blueprint $table) {
            $table->id();
            //CAMPOS TABLA
            //LLAVES FORANEAS
            $table->unsignedBigInteger('rule_id');
            $table->unsignedBigInteger('question_id');
            $table->foreign('rule_id')->references('id')->on('rules')->onDelete('cascade');
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
        Schema::dropIfExists('rule_question');
    }
};
