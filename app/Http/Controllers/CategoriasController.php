<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;
use Illuminate\Validation\ValidationException as ValidationException;

class CategoriasController extends Controller
{

    public function __construct(Categoria $obj){
        $this->obj = $obj;
    }
    
    public function index(){
        return view('admin.categorias');
    }

    public function show(Request $request)
    {
        $params = $request->all();

        $columns = [
            0 => 'id',
            1 => 'nome',
        ];

        $query = Categoria::select('*');

        // check search value exist
        if (!empty($params['search']['value'])) {
            $query->where(function ($query) use ($params) {
                $query->where('id', 'like', '%' . $params['search']['value'] . '%')
                    ->orWhere('nome', 'like', '%' . $params['search']['value'] . '%');
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
                '<div style="display: inline-block;">
                    <button class="btn btn-primary btn-edit-categorias" categorias_id="' . $linha->id . '">
                        <span class="bi bi-pencil" aria-hidden="true"></span>
                    </button>
                    <button class="btn btn-danger btn-del-categorias" categorias_id="' . $linha->id . '">
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

        try {

            $request->validate($this->obj->getRulesForCreate(), $this->obj->feedback());

        } catch (ValidationException $e) {

            $errors = $e->validator->errors()->toArray();
    
            foreach ($errors as $field => $errorMessages) {
                $json['error_list']["#$field"] = $errorMessages;
            }
    
            $json['status'] = 0;
        }

        if ($json['status'] === 1) {

            // Parte que faz o envio para o controlador.
            $acao = $request->input('acao');
    
            if ($acao === 'cadastrar') {
                $categoria = new Categoria();
                $categoria->nome = $request->input('nome');
    
                if ($categoria->save()) {
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

        $data = Categoria::find($id);

        $json['input']['id_edit']           = $data['id'];
        $json['input']['nome_edit']         = $data['nome'];
        $json['input']['descricao_edit']    = $data['descricao'];
        
        return response()->json($json);
    }

    public function update(Request $request){

        $id = $request->input('id');

        $json = [
            'status' => 1,
            'error_list' => [],
        ];

        try {

            $request->validate($this->obj->rules($id), $this->obj->feedback());

        } catch (ValidationException $e) {

            $errors = $e->validator->errors()->toArray();
    
            foreach ($errors as $field => $errorMessages) {
                $json['error_list']['#'.$field.'_edit'] = $errorMessages;
            }
    
            $json['status'] = 0;
        }

        if ($json['status'] === 1) {

            // Parte que faz o envio para o controlador.

            $acao = $request->input('acao');

            if ($acao === 'editar') {

                // Obtém o objeto Categoria pelo ID
                $categoria = Categoria::find($id);

                $categoria->nome = $request->input('nome');

                if ($categoria->update()) {
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

        $categorias = Categoria::find($id);

        if ($categorias->delete()) {
            $json['status'] = 2;
        } else {
            $json['status'] = 3;
        }
        
        return response()->json($json);
    }
}
