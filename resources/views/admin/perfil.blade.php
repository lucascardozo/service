@extends('admin.layouts.basico')

@section("title","Perfil")

@section('conteudo')

    @php
    /*
    * Página Perfil
    * Autor : Lucar Cardozo
    *  
    */
    @endphp

    <div class="pagetitle">
      <h1>Perfil</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="home">Home</a></li>
          <li class="breadcrumb-item active">Perfil</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section profile">
      <div class="row">
        <div class="col-xl-4">

          <div class="card">
            <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

              <img src="{{ $foto }}" alt="Perfil" class="rounded-circle">
              <h2>{{ $nome_usuario }}</h2>
              <h3>{{ $funcao }}</h3>
            </div>
          </div>

        </div>

        <div class="col-xl-8">

          <div class="card">
            <div class="card-body pt-3">
              <!-- Bordered Tabs -->
              <ul class="nav nav-tabs nav-tabs-bordered">

                <li class="nav-item">
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Sobre</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Editar Perfil</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Mudar Senha</button>
                </li>

              </ul>
              <div class="tab-content pt-2">

                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                  <!--<h5 class="card-title">Sobre</h5>
                  <p class="small fst-italic"></p>-->

                  <h5 class="card-title">Detalhes do perfil</h5>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label ">Nome completo</div>
                    <div class="col-lg-9 col-md-8">{{ $nome_usuario }}</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Função</div>
                    <div class="col-lg-9 col-md-8">{{ $funcao }}</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Email</div>
                    <div class="col-lg-9 col-md-8">{{ $email }}</div>
                  </div>

                </div>

                <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                  <!-- Profile Edit Form -->
                  <form id="form-perfil" >
                    <div class="row mb-3">
                      <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Imagem de perfil</label>
                      <div class="col-md-8 col-lg-9">

                        <?php if($foto != ''){ ?>
                            <img src="{{ $foto }}?vs=<?php echo date("H:i");?>" alt="imagem" />
                        <?php }else{ ?>
                            <img src="{{ url('storage/uploads/users/perfil.jpg') }}" alt="imagem">
                        <?php } ?>

                        <div class="pt-2">
                          <a href="fotoPerfil" class="btn btn-primary btn-sm" title="Upload da nova imagem de perfil"><i class="bi bi-upload"></i></a>
                        </div>
                      </div>
                    </div>

                    @csrf
                    <input type="hidden" name="acao" value="editar" />
                    <input type="hidden" id="id_edit" name="id" value="{{ $id_usuario }}" />

                    <div class="row mb-3">
                      <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Nome</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="nome" type="text" class="form-control" id="nome" value="{{ $nome_usuario }}">
                        <span class="help-block"></span>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Job" class="col-md-4 col-lg-3 col-form-label">Função</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="funcao" type="text" class="form-control" id="funcao" value="{{ $funcao }}">
                        <span class="help-block"></span>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="email" type="email" class="form-control" id="email" value="{{ $email }}">
                        <span class="help-block"></span>
                      </div>
                    </div>

                    <div class="text-center">
                      <button id="salvar-perfil" type="submit" class="btn btn-primary">Salvar mudanças</button>
                    </div>
                  </form><!-- End Profile Edit Form -->

                </div>

                <div class="tab-pane fade pt-3" id="profile-change-password">
                  <!-- Change Password Form -->
                  <form id="form_edit_senha">
                    @csrf
                    <input type="hidden" name="acao" value="mudar" />
                    <input type="hidden" id="id_edit_senha" name="id" value="{{ $id_usuario }}" />                    

                    <div class="row mb-3">
                      <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">Nova Senha</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="senha" type="password" class="form-control" id="senha_edit_senha">
                        <span class="help-block"></span>
                      </div>
                    </div>

                    <div class="text-center">
                      <button type="submit" id="btn_edit_senha"  class="btn btn-primary">Mudar Senha</button>
                    </div>
                  </form><!-- End Change Password Form -->

                </div>

              </div><!-- End Bordered Tabs -->

            </div>
          </div>

        </div>
      </div>
    </section>

    <script>
	
		/* Operações para o cadastro */
		
		$(function(){

            /* envia formulário edit */
			
			$("#form-perfil").submit(function(){
				
				var form = $('#form-perfil')[0];
				var formData = new FormData(form);
				 
				$.ajax({
				   type:"POST",
				   url: "perfil/editar",
				   dataType : "json",
				   data: formData,
				   processData: false,
				   contentType: false,
				   beforeSend: function(){
					   clearErrors();
					},
					success: function(response){
					   
					   if(response['status'] == 1){
						    swal("Sucesso!","Registro editado com sucesso!", "success");
                            location.reload();
					   }else if(response['status'] == 2){
						    swal("Error!","Houve um erro na ação, favor tentar novamente!", "error");
					   }else{
						   showErrorsModal(response['error_list']);
					   }
					}
				});

			   return false;
			});

            /* envia formulário edit senha */
			
			$("#form_edit_senha").submit(function(){
				
				var form = $('#form_edit_senha')[0];
				var formData = new FormData(form);
				 
				$.ajax({
				   type:"POST",
				   url: "perfil/editarSenha",
				   dataType : "json",
				   data: formData,
				   processData: false,
				   contentType: false,
				   beforeSend: function(){
					   clearErrors();
					},
					success: function(response){
					   
					   if(response['status'] == 1){
						   
						    swal("Sucesso!","Registro editado com sucesso!", "success");
                            location.reload();
						   
					   }else if(response['status'] == 2){
						    swal("Error!","Houve um erro na ação, favor tentar novamente!", "error");
					   }else if(response['status'] == 3){
						    swal("Atenção!","Registro editado com sucesso, será necessário realizar um novo login!", "warning").then(() => {
								// Redirecionar para a nova rota após o usuário clicar em "OK" no alerta
								window.location.href = "{{ route('login') }}";
							});
					   }else{
						   showErrorsModal(response['error_list']);
					   }
					}
				});

			   return false;
			});

        });
		
    </script>

@endsection