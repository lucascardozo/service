@extends('admin.layouts.basico')

@section("title","Foto")

@section('conteudo')

    @php
    /*
    * Página Foto Perfil
    * Autor : Lucar Cardozo
    *  
    */

    if($nivel != 1){
        /* página home */
        echo "<script>window.location.replace('home');</script>";
    }

    @endphp

   <div class="pagetitle">
      <h1>Foto</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route("admin.home") }}">Home</a></li>
          <li class="breadcrumb-item"><a href="{{ route("admin.usuarios") }}">Usuários</a></li>
          <li class="breadcrumb-item active">Foto</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Escolha uma foto</h5>
               <div class="panel-body table-responsive">
                    <!-- Estilos CSS -->
                    <link rel="stylesheet" href="{{ asset('assets/cropper-master/dist/cropper.min.css') }}" >
                    <link rel="stylesheet" href="{{ asset('assets/cropper-master/css/main.css') }}" >

                    <div class="container" id="crop-avatar">
                        <!-- Current avatar -->
                        <div class="avatar-view" title="Mudar imagem">
                             <?php if($user->foto != ''){ ?>
                                <img src="{{ url('storage/uploads/users/'.$user->foto) }}?vs=<?php echo date("H:i");?>" alt="imagem" />
                            <?php }else{ ?>
                                <img src="{{ url('storage/uploads/users/perfil.jpg') }}" alt="imagem">
                            <?php } ?>
                        </div>

                        <!-- Cropping modal -->
                        <div class="modal" id="avatar-modal" aria-hidden="true" aria-labelledby="avatar-modal-label" role="dialog" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form class="avatar-form" action="{{ route('admin.perfil.fotoCrop') }}" enctype="multipart/form-data" method="post">
                                        @csrf
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="avatar-modal-label">Mudar foto</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="avatar-body">
                                                <!-- Upload image and data -->
                                                <div class="avatar-upload">
                                                  <input type="hidden" class="avatar-src" name="id" value="{{ $user->id }}">
                                                  <input type="hidden" class="avatar-src" name="avatar_src">
                                                  <input type="hidden" class="avatar-data" name="avatar_data">
                                                  <label for="avatarInput">Localizar foto</label>
                                                  <input type="file" class="avatar-input" id="avatarInput" name="avatar_file">
                                                </div>

                                                <!-- Crop and preview -->
                                                <div class="row">
                                                  <div class="col- md-9">
                                                    <div class="avatar-wrapper"></div>
                                                  </div>
                                                </div>
                                          </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary btn-block avatar-save">Finalizar</button>
                                          <button type="button" class="btn btn-default" data-bs-dismiss="modal">Fechar</button>
                                        </div>
                                  </form>
                                </div>
                          </div>
                        </div><!-- /.modal -->

                        <!-- Loading state -->
                        <div class="loading" aria-label="Loading" role="img" tabindex="-1"></div>
                    </div>
                    <div align="center">
                        <a class="btn btn-primary" href="{{ route('admin.foto', ['id' => $user->id]) }}">Atualizar foto <span class="glyphicon glyphicon-refresh" aria-hidden="true"></span></a>
                        <a class="btn btn-warning" href="{{ route("admin.usuarios") }}">Voltar <span class="glyphicon glyphicon-share" aria-hidden="true"></span></a>
                    </div> 
                    <br>
                    <script src="{{ asset('assets/cropper-master/assets/js/jquery.min.js') }}" ></script>
                    <script src="{{ asset('assets/cropper-master/assets/js/bootstrap.min.js') }}" ></script>
                    <script src="{{ asset('assets/cropper-master/dist/cropper.min.js') }}" ></script>
                    <script src="{{ asset('assets/cropper-master/js/main.js') }}" ></script>
                </div>
            </div>
          </div>
        </div>
 
      </div>
    </section>

@endsection