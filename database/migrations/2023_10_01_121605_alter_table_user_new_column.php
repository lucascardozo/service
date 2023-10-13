<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Primeiro cria as colunas
        Schema::table('users', function (Blueprint $table) {
            $table->string('funcao');
            $table->string('foto');
            $table->unsignedBigInteger('grupo_id')->default(1);
            $table->string('status')->default('Ativo');
        });

        // depois alimenta os dados
        $grupoPadraoId = 1; // Assumindo que 1 é o ID do grupo padrão

        User::whereNull('grupo_id')->update(['grupo_id' => $grupoPadraoId]);

        //Por fim cria a chave estrangeira
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('grupo_id')->references('id')->on('grupos');
        });

        // Por fim cria um usuario admin

        User::create(
            [
                'name' => 'Admin',
                'email'=> 'admin@service.com',
                'password'=> Hash::make('12345678'),
                'funcao'=> 'Administrator',
                'foto'=> 'perfil.jpg',
                'grupo_id'=> 1,
                'status'=> 'Ativo'
            ]
        );
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('funcao');
            $table->dropColumn('foto');
            $table->dropForeign('users_grupo_id_foreign');
            $table->dropColumn('grupo_id');
            $table->dropColumn('status');
        });
    }
};
