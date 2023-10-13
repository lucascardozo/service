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
        Schema::create('atendimentos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("categoria_id");
            $table->unsignedBigInteger("user_id");
            $table->text("descricao");
            $table->date("dt_prazo");
            $table->string("status");
            $table->timestamps();
        });

        // create foreingh

        Schema::table('atendimentos', function (Blueprint $table) {
            $table->foreign('categoria_id')->references('id')->on('categoria');
            $table->foreign('user_id')->references('id')->on('users');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('atendimentos');
    }
};
