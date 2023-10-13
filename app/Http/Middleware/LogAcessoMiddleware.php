<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\LogAcesso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogAcessoMiddleware
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
        // Pega os dados do acesso
        $ip   = $request->server->get('REMOTE_ADDR');
        $rota = $request->getRequestUri();

        // Pega os dados do usuário Logado
        $user = Auth::user();
        $nome = $user->name;

        LogAcesso::create(['log' => "O usuário $nome através do Ip $ip requisitou a rota $rota"]);

        return $next($request);
    }
}
