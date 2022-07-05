<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLinkRedirecionamentoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('link_redirecionamento', function (Blueprint $table) {
            $table->id();
            $table->string('link');
            $table->integer('acesso_maximo');
            $table->integer('acessto_atual');
            $table->dateTime('data_validade');
            $table->boolean('link_default');
            $table->unsignedBigInteger('link_gerado_id');
            $table->foreign('link_gerado_id')->references('id')->on('link_gerado');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('link_redirecionamento');
    }
}
