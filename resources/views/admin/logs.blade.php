@extends('admin.layouts.basico')

@section('title', 'Logs')

@section('conteudo')

    @php
    /*
    * Página Logs
    * Autor : Lucar Cardozo
    *  
    */

    if ($nivel != 1) {
        return redirect('home');
    }

    @endphp

    <div class="pagetitle">
      <h1>Logs</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="home">Home</a></li>
          <li class="breadcrumb-item active">Logs</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    @include("admin.forms.formulariolog")
    
    <section class="section">
      <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body table-responsive">
                  <p style="margin-top: 10px;">Total de registros cadastrados: {{ $logs->total() }}</p>
                  <!-- Table with stripped rows -->
                  <table class="table table-striped" style="width:100%;">
                    <thead>
                      <tr>
                        <th scope="col" >Data</th>
                        <th scope="col" >Descrição do log</th>
                      </tr>
                    </thead>
                    <tbody>
                        @forelse ($logs as $log)
                            <tr>
                                <th scope="row">{{ date('d/m/Y H:i:s', strtotime($log->created_at)) }}</th>
                                <td>{{ $log->log }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2">Nenhum Registro encontrado</td>
                            </tr>
                        @endforelse
                    </tbody>
                  </table>
                  <!-- End Table with stripped rows -->
                  <!-- Links de Paginação -->
                  <div class="pagination justify-content-center pagination-sm">
                    {{ $logs->appends($request)->links('vendor.pagination.bootstrap-4') }}
                  </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    
@endsection