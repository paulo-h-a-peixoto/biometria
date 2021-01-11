<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntradaSaida extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entrada_saida', function (Blueprint $table) {
            $table->id();
            $table->string('n_relatorio');
            $table->string('documento');
            $table->string('hora_entrada');
            $table->string('hora_saida');
            $table->string('data');
            $table->string('justify')->default('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('entrada_saida');
    }
}
