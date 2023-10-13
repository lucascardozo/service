<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grupo;

class GruposController extends Controller
{
    public function index(){
        return view('admin.grupos');
    }

    public function show(Request $request)
    {
        $params = $request->all();

        $columns = [
            0 => 'id',
            1 => 'nome',
            2 => 'descricao',
        ];

        $query = Grupo::select('*');

        // check search value exist
        if (!empty($params['search']['value'])) {
            $query->where(function ($query) use ($params) {
                $query->where('id', 'like', '%' . $params['search']['value'] . '%')
                    ->orWhere('nome', 'like', '%' . $params['search']['value'] . '%')
                    ->orWhere('descricao', 'like', '%' . $params['search']['value'] . '%');
            });
        }

        $totalRecords = $query->count();

        $query->orderBy($columns[$params['order'][0]['column']], $params['order'][0]['dir'])
            ->offset($params['start'])
            ->limit($params['length']);

        $queryRecordsFiltered = $query->count();

        $data = [];

        foreach ($query->get() as $linha) {
            $row = [
                $linha->id,
                $linha->nome,
                $linha->descricao,
                '<div style="display: inline-block;">
                    <button class="btn btn-primary btn-edit-grupos" grupos_id="' . $linha->id . '">
                        <span class="bi bi-pencil" aria-hidden="true"></span>
                    </button>
                    <button class="btn btn-danger btn-del-grupos" grupos_id="' . $linha->id . '">
                        <span class="bi bi-trash" aria-hidden="true"></span>
                    </button>
                </div>',
            ];
            $data[] = $row;
        }

        $json = [
            "draw" => intval($params['draw']),
            "recordsTotal" => intval($totalRecords),
            "recordsFiltered" => intval($queryRecordsFiltered),
            "data" => $data,
        ];

        return response()->json($json);
    }


    public function create(Request $request)
    {
        $json = [
            'status' => 1,
            'error_list' => [],
        ];

        if (empty($request->input('nome'))) {
            $json['error_list']['#nome'] = 'Nome é obrigatório!';
        }

        if(!empty($json['error_list'])){
            $json['status'] = 0;
        }else{

            // Parte que faz o envio para o controlador.

            $acao = $request->input('acao');

            if ($acao === 'cadastrar') {

                $grupo = new Grupo();
                $grupo->nome = $request->input('nome');
                $grupo->descricao = $request->input('descricao');

                if ($grupo->save()) {
                    $json['status'] = 1;
                } else {
                    $json['status'] = 2;
                }
            }
        }

        return response()->json($json);
    }

    public function obter(Request $request){

        $json = [
            'input' => [],
        ];

        $id = $request->input('id');

        $grupo = new Grupo();

        $data = Grupo::find($id);

        $json['input']['id_edit']           = $data['id'];
        $json['input']['nome_edit']         = $data['nome'];
        $json['input']['descricao_edit']    = $data['descricao'];
        
        return response()->json($json);
    }

    public function update(Request $request){

        $json = [
            'status' => 1,
            'error_list' => [],
        ];

        if (empty($request->input('nome'))) {
            $json['error_list']['#nome_edit'] = 'Nome é obrigatório!';
        }

        if(!empty($json['error_list'])){
            $json['status'] = 0;
        }else{

            // Parte que faz o envio para o controlador.

            $acao = $request->input('acao');

            if ($acao === 'editar') {

                $id = $request->input('id');

                // Obtém o objeto Grupos pelo ID
                $grupo = Grupo::find($id);

                $grupo->nome = $request->input('nome');
                $grupo->descricao = $request->input('descricao');

                if ($grupo->update()) {
                    $json['status'] = 1;
                } else {
                    $json['status'] = 2;
                }
            }
        }

        return response()->json($json);
    }

    public function delete(Request $request){

        $json = [
            'status' => 1,
        ];

        $id = $request->input('id');

        $grupo = new Grupo();

        $grupo = Grupo::find($id);

        if ($grupo->delete()) {
            $json['status'] = 2;
        } else {
            $json['status'] = 3;
        }
        
        return response()->json($json);
    }
}
