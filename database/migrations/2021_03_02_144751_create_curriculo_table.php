<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurriculoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('curriculos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('nome');
            $table->string('email');
            $table->string('telefone');
            $table->string('cargo');
            $table->string('escolaridade');
            $table->text('observacao');
            $table->string('arquivo');
            $table->string('ip', 20);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('curriculo');
    }
}
