@extends('admin.layouts.basico')

@section('title', 'Backups')

@section('conteudo')

    @php
    /*
    * Página Backups
    * Autor : Lucar Cardozo
    *  
    */

    if ($nivel != 1) {
        return redirect('home');
    }

    @endphp

    <script language="JavaScript"> 
        function confirmBox() {   if (confirm("Excluir?")) {  return true;}  else { return false;} }
    </script>

    <div class="pagetitle">
      <h1>Backups</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="home">Home</a></li>
          <li class="breadcrumb-item active">Backups</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">
            @if ($nivel == 1)
               <a href="{{ route("admin.backups.gerar") }}" class="btn btn-primary" >Gerar Backup <span class="bi bi-download" aria-hidden="true"></span></a>
            @endif
            <br /><br />
            <div class="card">
                <div class="card-body table-responsive">
                  <p style="margin-top: 10px;">Total de registros cadastrados: {{ $backups->total() }}</p>
                  <!-- Table with stripped rows -->
                  <table class="table table-striped" style="width:100%;">
                    <thead>
                      <tr>
                        <th scope="col" >Data</th>
                        <th scope="col" >Backup</th>
                        <th scope="col" >Ação</th>
                      </tr>
                    </thead>
                    <tbody>
                        @forelse ($backups as $backup)
                            <tr>
                                <th scope="row">{{ date('d/m/Y H:i:s', strtotime($backup->created_at)) }}</th>
                                <td>{{ $backup->backup }}</td>
                                <td>
                                @if ($nivel == 1)
                                    <a href="{{ route("admin.backups.download",['file'=>$backup->file]) }}" download class="btn btn-primary" ><span class="bi bi-download" aria-hidden="true"></span></a>
                                    <a href="{{ route("admin.backups.deletar",['id'=>$backup->id]) }}" class="btn btn-danger" onclick="return confirmBox()" ><span class="bi bi-trash" aria-hidden="true"></span></a>
                                @endif
                            </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">Nenhum Registro encontrado</td>
                            </tr>
                        @endforelse
                    </tbody>
                  </table>
                  <!-- End Table with stripped rows -->
                  <!-- Links de Paginação -->
                  <div class="pagination justify-content-center pagination-sm">
                    {{ $backups->links('vendor.pagination.bootstrap-4') }}
                  </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    
@endsection