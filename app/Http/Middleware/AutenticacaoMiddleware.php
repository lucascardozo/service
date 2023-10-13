<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AutenticacaoMiddleware
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
        if (Auth::check()) {
            // O usuário está autenticado, você pode acessar os dados assim:
            $usuario = Auth::user();
            $nome = $usuario->name;
            $email = $usuario->email;
            // Outros dados do usuário, se disponíveis
        
            // Faça o que você precisa com os dados do usuário
            return $next($request);

        } else {
            // O usuário não está autenticado
            return Redirect()->route('login',['error'=>2]);
        }
    }
}
