<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Atendimento;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ChartsController extends Controller
{
    public function listAtendimentos(){

        $json                                  = array();
        $json['qtd_atendimentos']              = 0;
        $json['qtd_atendimentos_concluidos']   = 0;
        $json['qtd_atendimentos_pendentes']    = 0;
        $json['qtd_atendimentos_hoje']         = 0;
        
        $qtd_atendimentos               = Atendimento::all()->count();
        $qtd_atendimentos_concluidos    = Atendimento::where("status","Concluido")->count();
        $qtd_atendimentos_pendentes     = Atendimento::where("status","Pendente")->count();
        $qtd_atendimentos_hoje          = Atendimento::whereDate('created_at', '=', Carbon::today()->toDateString())->count();
        
        $json['qtd_atendimentos']               = $qtd_atendimentos;
        $json['qtd_atendimentos_concluidos'] 	= $qtd_atendimentos_concluidos;
        $json['qtd_atendimentos_pendentes'] 	= $qtd_atendimentos_pendentes;
        $json['qtd_atendimentos_hoje'] 	        = $qtd_atendimentos_hoje;

        return response()->json($json);
    }

    public function listAtendimentosMes(){

        $json = array();

        $query = Atendimento::select(
                                    DB::raw('DATE_FORMAT(created_at, "%b/%Y") as mes_ano'),
                                    DB::raw('COUNT(created_at) AS qtd_cadastro')
                                    )
                                    ->groupBy('mes_ano')
                                    ->orderBy("created_at","ASC")
                                    ->LIMIT(12)->get();

        foreach($query as $e){
            $json[] = array(
                'name'	=> $e->mes_ano,
                'value'	=> (int)$e->qtd_cadastro,
            );
        }

        return response()->json($json);
    }

    public function listAtendimentosCategorias(){

        $json = array();

        $query = DB::table('categoria as t1')
                ->select('t1.nome', DB::raw('COUNT(t2.categoria_id) AS qtd'))
                ->leftJoin('atendimentos as t2', 't1.id', '=', 't2.categoria_id')
                ->groupBy('t1.nome')
                ->havingRaw('qtd > 0')
                ->get();
  
        foreach($query as $e){
            $json[] = array(
                'name'	=> $e->nome,
                'value'	=> (int)$e->qtd,
            );
        }

        return response()->json($json);
    }
}
