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
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            //CAMPOS TABLA
            $table->string('name');
            $table->string('slug');
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->longText('body')->nullable();
            $table->text('example')->nullable();
            $table->text('exception')->nullable();
            //ACTUALIZACION SE AGREGARON LOS CAMPOS TYPE Y CLASIFICATION
            $table->string('type');
            $table->string('clasification');

            //LLAVES FORANEAS
            $table->unsignedBigInteger('rule_id');
            $table->foreign('rule_id')->references('id')->on('rules')->onDelete('cascade');

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
        Schema::dropIfExists('notes');
    }
};
