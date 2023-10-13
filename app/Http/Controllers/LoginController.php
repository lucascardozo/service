<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index(Request $request){

        $error = $request->get('error');

        return view('login',['title'=>'Login','error' => $error]);
    }

    public function logar(Request $request){

        // regras de validação

        $regras = [
            'login' => 'email',
            'senha' => 'required'
        ];

        $feedback = [
            'login.email' => 'O campo deve ser um email.',
            'senha.required' => 'A senha é obrigatória.'
        ];

        $request->validate($regras,$feedback);

        $email = $request->input('login');
        $senha = $request->input('senha');

        if (Auth::attempt(['email' => $email, 'password' => $senha])) {
            // O usuário está autenticado, não é necessário criar uma sessão personalizada
            return redirect()->route('admin.home');
        } else {
            // Autenticação falhou, trate o erro apropriado
            return redirect()->route('login',['error'=> 1]);
        }
    }

    public function sair(){

        Auth::logout(); // Realiza o logout do usuário
        return redirect()->route('login');
    }
}
