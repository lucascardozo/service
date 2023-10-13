<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Atendimento;
use App\Models\Categoria;
use Illuminate\Validation\ValidationException as ValidationException;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AtendimentosController extends Controller
{
    public function __construct(Atendimento $obj){
        $this->obj = $obj;
    }
    
    public function index(){

        $categorias = Categoria::all();

        return view('admin.atendimentos',compact('categorias'));
    }

    public function show(Request $request)
    {
        $params = $request->all();

        $columns = [
            0 => 'id',
            1 => 'categoria_id',
            2 => 'dt_prazo',
            3 => 'status',
        ];

        $query = Atendimento::with(['categoria','user'])->select('*');

        // check search value exist
        if (!empty($params['search']['value'])) {
            $query->where(function ($query) use ($params) {
                $query->where('id', 'like', '%' . $params['search']['value'] . '%')
                    ->orWhereHas('categoria', function ($subQuery) use ($params) {
                        $subQuery->where('nome', 'like', '%' . $params['search']['value'] . '%');
                    })
                    ->orWhere('status', 'like', '%' . $params['search']['value'] . '%')
                    ->orWhere(DB::raw("DATE_FORMAT(dt_prazo, '%d/%m/%Y')"), '=', $params['search']['value']);
            });
        }

        $totalRecords = $query->count();

        $query->orderBy($columns[$params['order'][0]['column']], $params['order'][0]['dir'])
            ->offset($params['start'])
            ->limit($params['length']);

        $queryRecordsFiltered = $query->count();

        $data = [];

        foreach ($query->get() as $linha) {

            if($linha->status == 'Pendente'){ 
                $status = '<span class="badge bg-warning">'.$linha->status.'</span>';
            }else{ 
                $status = '<span class="badge bg-success">'.$linha->status.'</span>';
            }
            
            $dt_prazo = Carbon::parse($linha->dt_prazo)->format('d/m/Y');

            $row = [
                $linha->id,
                $linha->categoria->nome,
                $dt_prazo,
                $status,
                '<div style="display: inline-block;">
                    <button class="btn btn-primary btn-edit-atendimentos" atendimentos_id="' . $linha->id . '">
                        <span class="bi bi-pencil" aria-hidden="true"></span>
                    </button>
                    <button class="btn btn-danger btn-del-atendimentos" atendimentos_id="' . $linha->id . '">
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

            $request->validate($this->obj->rules(), $this->obj->feedback());

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
                $atendimento = new Atendimento();

                $atendimento->categoria_id = $request->input('categoria_id');
                $atendimento->user_id   = $request->input('user_id');
                $atendimento->descricao = $request->input('descricao');
                $atendimento->dt_prazo  = $request->input('dt_prazo');
                $atendimento->status    = $request->input('status');
    
                if ($atendimento->save()) {
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

        $data = Atendimento::find($id);

        $json['input']['id_edit']           = $data['id'];
        $json['input']['categoria_id_edit'] = $data['categoria_id'];
        $json['input']['user_id_edit']      = $data['user_id'];
        $json['input']['descricao_edit']    = $data['descricao'];
        $json['input']['dt_prazo_edit']     = $data['dt_prazo'];
        $json['input']['status_edit']       = $data['status'];
        
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

                // Obtém o objeto atendimento pelo ID
                $atendimento = Atendimento::find($id);

                $atendimento->categoria_id = $request->input('categoria_id');
                $atendimento->user_id   = $request->input('user_id');
                $atendimento->descricao = $request->input('descricao');
                $atendimento->dt_prazo  = $request->input('dt_prazo');
                $atendimento->status    = $request->input('status');

                if ($atendimento->update()) {
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

        $atendimento = Atendimento::find($id);

        if ($atendimento->delete()) {
            $json['status'] = 2;
        } else {
            $json['status'] = 3;
        }
        
        return response()->json($json);
    }
}
