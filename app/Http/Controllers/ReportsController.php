<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use App\Models\User;
use App\Models\Categoria;
use App\Models\Atendimento;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    public function relatorioUsuarios(Request $request){

        // Recebe os dados do modal
        $data_inicial   = $request->input('data_inicial');
        $data_final     = $request->input('data_final');

        $grupo          = $request->input('grupo');
        $status         = $request->input('status');

        // faz a query
        $query = User::where('grupo_id', 'like', '%' . $grupo . '%')
            ->where('status', 'like', '%' . $status . '%');

        // Adicione a condição de intervalo de datas apenas se ambas as datas estiverem presentes
        if (!empty($data_inicial) && !empty($data_final)) {
            $query->whereBetween('created_at', [$data_inicial, $data_final]);
        }

        $dados = $query->get();

        // Define a quantidade de registros por página
        $qtdPorPage = 10;

        // Pagina os dados
        $dados = $dados->chunk($qtdPorPage);

        // Calcula o número total de páginas
        $totalPaginas = $dados->count();

        $pathToImage = public_path('assets/img/logo_rel.jpg');
        $imageData   = base64_encode(file_get_contents($pathToImage));
        $imageSrc    = 'data:image/png;base64,' . $imageData;

        // Carregue a view Blade
        $view = view('admin.reports.relatorio', compact('dados', 'totalPaginas','imageSrc'));

        // Converte a view para PDF
        $pdf = PDF::loadHtml($view);

        // Adicione o título, logotipo, etc.
        $pdf->setOptions(['isHtml5ParserEnabled' => true, 'isPhpEnabled' => true]);
        $pdf->setPaper('a4', 'portrait');

        // Retorne o PDF ou salve-o no servidor
        return $pdf->stream('relatorio.pdf');
       
    }

    public function relatorioCategoria(Request $request){

        // Recebe os dados do modal
        $data_inicial   = $request->input('data_inicial');
        $data_final     = $request->input('data_final');

        // faz a query

        // Adicione a condição de intervalo de datas apenas se ambas as datas estiverem presentes
        if (!empty($data_inicial) && !empty($data_final)) {
            $dados = Categoria::whereBetween('created_at', [$data_inicial, $data_final])->get();
        }else{
            $dados = Categoria::all();
        }

        // Define a quantidade de registros por página
        $qtdPorPage = 22;

        // Pagina os dados
        $dados = $dados->chunk($qtdPorPage);

        // Calcula o número total de páginas
        $totalPaginas = $dados->count();

        $pathToImage = public_path('assets/img/logo_rel.jpg');
        $imageData   = base64_encode(file_get_contents($pathToImage));
        $imageSrc    = 'data:image/png;base64,' . $imageData;

        // Carregue a view Blade
        $view = view('admin.reports.relatorio', compact('dados', 'totalPaginas','imageSrc'));

        // Converte a view para PDF
        $pdf = PDF::loadHtml($view);

        // Adicione o título, logotipo, etc.
        $pdf->setOptions(['isHtml5ParserEnabled' => true, 'isPhpEnabled' => true]);
        $pdf->setPaper('a4', 'portrait');

        // Retorne o PDF ou salve-o no servidor
        return $pdf->stream('relatorio.pdf');
       
    }

    public function relatorioAtendimentos(Request $request){

        // Recebe os dados do modal
        $data_inicial   = $request->input('data_inicial');
        $data_final     = $request->input('data_final');

        $categoria_id   = $request->input('categoria_id');
        $status         = $request->input('status');

        // faz a query
        $query = Atendimento::with('categoria')->where('categoria_id', 'like', '%' . $categoria_id . '%')
            ->where('status', 'like', '%' . $status . '%');

        // Adicione a condição de intervalo de datas apenas se ambas as datas estiverem presentes
        if (!empty($data_inicial) && !empty($data_final)) {
            $query->whereBetween(DB::raw('DATE(created_at)'), [$data_inicial, $data_final]);
        }

        $dados = $query->get();

        // Formate a data no formato desejado
        $dt_prazo = $dados->map(function ($item) {
            $item->created_at_formatada = Carbon::parse($item->dt_prazo)->format('d/m/Y');
            return $item;
        });

        // Define a quantidade de registros por página
        $qtdPorPage = 10;

        // Pagina os dados
        $dados = $dados->chunk($qtdPorPage);

        // Calcula o número total de páginas
        $totalPaginas = $dados->count();

        $pathToImage = public_path('assets/img/logo_rel.jpg');
        $imageData   = base64_encode(file_get_contents($pathToImage));
        $imageSrc    = 'data:image/png;base64,' . $imageData;

        // Carregue a view Blade
        $view = view('admin.reports.relatorio-atendimentos', compact('dados', 'totalPaginas','imageSrc','dt_prazo'));

        // Converte a view para PDF
        $pdf = PDF::loadHtml($view);

        // Adicione o título, logotipo, etc.
        $pdf->setOptions(['isHtml5ParserEnabled' => true, 'isPhpEnabled' => true]);
        $pdf->setPaper('a4', 'portrait');

        // Retorne o PDF ou salve-o no servidor
        return $pdf->stream('relatorio.pdf');
       
    }
}
