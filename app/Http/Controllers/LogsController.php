<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LogAcesso;

class LogsController extends Controller
{
    public function index(Request $request){

        // pega os dados da consulta
        $periodo    = $request->input('periodo');
        $descricao  = $request->input('descricao');

        //Faz a busca no banco de dados
        $logs = LogAcesso::where(function ($query) use ($periodo){
                if (!empty($periodo)) {
                    $query->whereDate('created_at', $periodo);
                }
            })
            ->where('log', 'like', '%' . $descricao . '%')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view("admin.logs",['logs'=>$logs,'request'=>$request->all()]);
    }
}
