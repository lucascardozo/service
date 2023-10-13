<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Grupo;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Image;

class UsuariosController extends Controller
{
    public function index(){

        // Chama uma lista de grupos
        $grupos = Grupo::all();

        return view("admin.usuarios", compact('grupos'));
    }

    public function perfil(){

        return view("admin.perfil");
    }

    public function fotoPerfil(){

        return view("admin.fotoPerfil");
    }

    public function foto($id){

        $user = User::find($id);

        return view("admin.foto",['user'=>$user]);
    }

    public function mostraId($usuario_email){

        $user = new User();

        $usuario = $user->where('email',$usuario_email)->get()->first();

        return $usuario;

    }

    public function show(Request $request){

        $params = $request->all();

        $columns = [
            0 => 'id',
            1 => 'name',
            2 => 'email',
            3 => 'funcao',
            4 => 'grupo_id',
            5 => 'status'
        ];

        $query = User::with(['grupo'])->select('*');

       // check search value exist
       if (!empty($params['search']['value'])) {
            $query->where(function ($query) use ($params) {
                $query->where('id', 'like', '%' . $params['search']['value'] . '%')
                    ->orWhere('name', 'like', '%' . $params['search']['value'] . '%')
                    ->orWhere('email', 'like', '%' . $params['search']['value'] . '%')
                    ->orWhere('funcao', 'like', '%' . $params['search']['value'] . '%')
                    ->orWhere('status', 'like', '%' . $params['search']['value'] . '%')
                    ->orWhereHas('grupo', function ($query) use ($params) {
                        $query->where('nome', 'like', '%' . $params['search']['value'] . '%');
                    });
            });
        }

        $totalRecords = $query->count();

        $query->orderBy($columns[$params['order'][0]['column']], $params['order'][0]['dir'])
            ->offset($params['start'])
            ->limit($params['length']);

        $queryRecordsFiltered = $query->count();

        $data = [];

        foreach ($query->get() as $linha) {

            $foto = url('storage/uploads/users/'.$linha->foto);

            $foto = '<img style="max-height: 36px;" src="'.$foto.'" class="rounded-circle" alt="">';

            if($linha->status == 'Ativo'){ 
                $status = '<span class="badge bg-success">'.$linha->status.'</span>';
            }else{ 
                $status = '<span class="badge bg-danger">'.$linha->status.'</span>';
            }

            /* Botões */
		    $botoes  ='';

		    $botoes  .= '<div style="display: inline-block;">';
                $botoes .= '<a href="#" class="btn btn-primary btn-edit-usuarios" usuarios_id="'.$linha->id.'"><span class="bi bi-pencil" aria-hidden="true"></span></a>';
                
                $botoes .= '<a href="#" class="btn btn-primary btn-senha-usuarios" usuarios_id="'.$linha->id.'"><span class="bi bi-lock" aria-hidden="true"></span></a>';
                $botoes .= '<a href="foto/'.$linha->id.'" class="btn btn-primary" ><span class="bi bi-image" aria-hidden="true"></span></a>';
                $botoes .= '<a href="#" class="btn btn-danger btn-del-usuarios" usuarios_id="'.$linha->id.'"><span class="bi bi-trash" aria-hidden="true"></span></a>';
		    $botoes .= '</div>';

            $row = [
                $foto,
                $linha->id,
                $linha->name,
                $linha->email,
                $linha->funcao,
                $linha->grupo->nome,
                $status,
                $botoes
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

        if (empty($request->input('email'))) {
            $json['error_list']['#email'] = 'Email é obrigatório!';
        }

        if (empty($request->input('funcao'))) {
            $json['error_list']['#funcao'] = 'Função é obrigatório!';
        }

        if (empty($request->input('nivel'))) {
            $json['error_list']['#nivel'] = 'Grupo é obrigatório!';
        }

        if (empty($request->input('senha'))) {
            $json['error_list']['#senha'] = 'Senha é obrigatório!';
        }

        if(!empty($json['error_list'])){
            $json['status'] = 0;
        }else{

            // Parte que faz o envio para o controlador.

            $acao = $request->input('acao');

            if ($acao === 'cadastrar') {

                $user = new User();
                $user->name        = $request->input('nome');
                $user->email       = $request->input('email');
                $user->password    = Hash::make($request->input('senha'));
                $user->funcao      = $request->input('funcao');
                $user->foto        = 'perfil.jpg';
                $user->grupo_id    = $request->input('nivel');
                $user->status      = 'Ativo';

                if ($user->save()) {
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

        $json['situacao'] 	= "";

        $id = $request->input('id');

        $data = User::find($id);

        $json['input']['id_edit']   	= $data['id'];
        $json['input']['nome_edit']   	= $data['name'];
        $json['input']['email_edit'] 	= $data['email'];
        $json['input']['nivel_edit'] 	= $data['grupo_id'];
        $json['input']['funcao_edit'] 	= $data['funcao'];

        $situacao = "";

        if($data['status'] == 'Ativo'){
            $situacao .= 	'<label class="toggle">
                <input type="radio" id="status_edit" name="status"  value="Ativo" checked> <span class="label-text">Ativo</span>
            </label>
            &nbsp;&nbsp;
            <label class="toggle">
                <input type="radio" id="status_edit" name="status"  value="Inativo" > <span class="label-text">Inativo</span>
            </label>';
        }else{
            $situacao .= 	'<label class="toggle">
                <input type="radio" id="status_edit" name="status"  value="Ativo"> <span class="label-text">Ativo</span>
            </label>
            &nbsp;&nbsp;
            <label class="toggle">
                <input type="radio" id="status_edit" name="status"  value="Inativo" checked> <span class="label-text">Inativo</span>
            </label>';
        }

        $json['situacao'] = $situacao;
        
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

        if (empty($request->input('email'))) {
            $json['error_list']['#email_edit'] = 'Email é obrigatório!';
        }

        if (empty($request->input('funcao'))) {
            $json['error_list']['#funcao_edit'] = 'Função é obrigatório!';
        }

        if (empty($request->input('nivel'))) {
            $json['error_list']['#nivel_edit'] = 'Grupo é obrigatório!';
        }

        if(!empty($json['error_list'])){
            $json['status'] = 0;
        }else{

            // Parte que faz o envio para o controlador.

            $acao = $request->input('acao');

            if ($acao === 'editar') {

                $id = $request->input('id');

                // Obtém o objeto Grupos pelo ID
                $user = User::find($id);

                $user->name        = $request->input('nome');
                $user->email       = $request->input('email');
                $user->funcao      = $request->input('funcao');
                $user->grupo_id    = $request->input('nivel');
                $user->status      = $request->input('status');

                if ($user->update()) {
                    $json['status'] = 1;
                } else {
                    $json['status'] = 2;
                }
            }
        }

        return response()->json($json);
    }

    public function updatePerfil(Request $request){

        $json = [
            'status' => 1,
            'error_list' => [],
        ];

        if (empty($request->input('nome'))) {
            $json['error_list']['#nome_edit'] = 'Nome é obrigatório!';
        }

        if (empty($request->input('email'))) {
            $json['error_list']['#email_edit'] = 'Email é obrigatório!';
        }

        if (empty($request->input('funcao'))) {
            $json['error_list']['#funcao_edit'] = 'Função é obrigatório!';
        }

        if(!empty($json['error_list'])){
            $json['status'] = 0;
        }else{

            // Parte que faz o envio para o controlador.

            $acao = $request->input('acao');

            if ($acao === 'editar') {

                $id = $request->input('id');

                // Obtém o objeto Grupos pelo ID
                $user = User::find($id);

                $user->name        = $request->input('nome');
                $user->email       = $request->input('email');
                $user->funcao      = $request->input('funcao');

                if ($user->update()) {
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

        $user = User::find($id);

        if ($user->delete()) {
            $json['status'] = 2;
        } else {
            $json['status'] = 3;
        }
        
        return response()->json($json);
    }

    public function obterSenha(Request $request){

        $json = [
            'input' => [],
        ];

        $id = $request->input('id');

        $data = User::find($id);

        $json['input']['id_edit_senha']   	= $data['id'];
        $json['input']['nome_edit_senha']   = $data['name'];

        return response()->json($json);
    }

    public function updateSenha(Request $request){

        $json = [
            'status' => 1,
            'error_list' => [],
        ];

        if (empty($request->input('senha'))) {
            $json['error_list']['#senha_edit_senha'] = 'Senha é obrigatório!';
        }

        if(!empty($json['error_list'])){
            $json['status'] = 0;
        }else{

            // Parte que faz o envio para o controlador.

            $acao = $request->input('acao');

            if ($acao === 'mudar') {

                // Obter o usuário autenticado
                $usuario = Auth::user();

                $id = $request->input('id');

                // Obtém o objeto Grupos pelo ID
                $user = User::find($id);

                $nova_senha = Hash::make($request->input('senha'));

                $user->password  = $nova_senha;

                if ($user->update()) {

                    $json['status'] = 1;

                    // verifica se o usuário logado é o mesmo da requisição
                    if($usuario->id == $id){

                        // Verificar se a nova senha é diferente da senha antiga
                        if (!Hash::check($nova_senha, $usuario->senha)) {

                            $json['status'] = 3;

                            // Invalidar a sessão apenas se a senha for alterada
                            Auth::logout(); // Realiza o logout do usuário
                        }
                    }

                } else {
                    $json['status'] = 2;
                }
            }
        }

        return response()->json($json);
    }

    public function fotoCrop(Request $request){

        // Verifica se a requisição possui um arquivo de imagem
        if ($request->hasFile('avatar_file')) {

            // Obter os dados da imagem cortada do formulário
            $avatarData = $request->input('avatar_data');

            // Decodificar os dados JSON
            $avatarData = json_decode($avatarData);

            // Obter a imagem enviada pelo formulário
            $avatarFile = $request->file('avatar_file');

            // Se a imagem e os dados de corte estiverem presentes
            if ($avatarFile && $avatarData) {

                // Converta os valores para inteiros
                $width = (int)$avatarData->width;
                $height = (int)$avatarData->height;
                $x = (int)$avatarData->x;
                $y = (int)$avatarData->y;

                // Criar uma instância da imagem usando o Intervention Image
                $image = Image::make($avatarFile);

                // Certifique-se de que os valores são inteiros
                $width = max(1, $width);  // Garante que não seja zero ou negativo
                $height = max(1, $height);
                $x = max(0, $x);  // Garante que não seja negativo
                $y = max(0, $y);

                // Aplicar as coordenadas de corte
                $image->crop($width, $height, $x, $y);

                // Redimensionar para 600x600 (ou suas dimensões desejadas)
                $image->resize(600, 600);

                // path to image
                $path = url('storage/uploads/users/');

                // Salvar a imagem
                $nomeArquivo = 'usuario_' . $request->input('id') . '.jpg';
                $caminhoArquivo = public_path('storage/uploads/users/' . $nomeArquivo);
                $image->save($caminhoArquivo);

                // Aqui, você pode salvar o caminho do arquivo no banco de dados, se necessário
                $id = $request->input('id');

                // Obtém o objeto Grupos pelo ID
                $user = User::find($id);

                $user->foto = $nomeArquivo;

                if ($user->update()) {
                    $msg = "Upload bem-sucedido!";
                } else {
                    $msg = "Erro ao realizar a atualização!";
                }
            }else{
                $msg = "Erro no processamento da imagem.";
            }

        } else {
            $msg = "Nenhuma imagem enviada.";
        }

        $json = [
            'state'  => 200,
            'message' => $msg,
            'result' => $path.'/'.$nomeArquivo
        ];

        return response()->json($json);
    }
}
