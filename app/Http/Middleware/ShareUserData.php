<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Models\Grupo;
use App\Models\Categoria;

class ShareUserData
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Lista os grupos
        $grupos = Grupo::all();

        // Lista categorias
        $categorias = Categoria::all();

        if (Auth::check()) {
            
            $usuario = Auth::user();

            View::share([
                'id_usuario' => $usuario->id,
                'nome_usuario' => $usuario->name,
                'funcao' => $usuario->funcao,
                'email' => $usuario->email,
                'nivel' => $usuario->grupo_id,
                'nome_grupo' => $usuario->grupo->nome,
                'foto' => url('storage/uploads/users/'.$usuario->foto),
                // Adicione quantas variáveis desejar
                'lista_grupos' => $grupos,
                'lista_categorias' => $categorias,
            ]);
        }

        return $next($request);
    }
}
