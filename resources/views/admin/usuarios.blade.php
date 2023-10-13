@extends('admin.layouts.basico')

@section("title","Usuários")

@section('conteudo')

    @php
    /*
    * Página usuarios
    * Autor : Lucar Cardozo
    *  
    */

    if($nivel != 1){
        echo "<script>window.location.replace('home');</script>";
    }

    @endphp

    <div class="pagetitle">
      <h1>Usuários</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="home">Home</a></li>
          <li class="breadcrumb-item active">Usuários</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    
    <section class="section">
		<div class="row">
			<div class="col-lg-12">
				<?php if($nivel == 1){ ?>  
					<a href="#" data-bs-toggle="modal" data-bs-target="#myModal-usuarios-add" class="btn btn-outline btn-primary" >Adicionar novo <i class="bi bi-plus-lg"></i></a>
				<?php } ?>
				<br /><br />
				<div class="card">
					<div class="card-body">
					  <br /><br />
					  <!-- Table with stripped rows -->
					  <table id="dt_usuarios" class="table" style="width:100%;">
						<thead>
						  <tr class="tableheader">
							<th scope="col" class="no-sort" >Foto</th>
							<th scope="col" >Cód.</th>
							<th scope="w-100" >Nome</th>
							<th scope="col" >Login</th>
							<th scope="col" >Função</th>
							<th scope="col" >Grupo</th>
							<th scope="col" >Status</th>
							<th class="dt-center no-sort" scope="col" >Ação</th>
						  </tr>
						</thead>
						<tbody></tbody>
					  </table>
					  <!-- End Table with stripped rows -->
						<div class="modal fade" id="myModal-usuarios-edit">
							<div class="modal-dialog modal-xl">
								<div class="modal-content">
									<div class="modal-header">
										<h4 class="modal-title">Alterar usuário</h4>
										<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
									</div>
									<div class="container"></div>
									<div class="modal-body">
										<form id="form_usuarios_edit" style="border:none">
                                            @csrf
											<input type="hidden" name="acao" value="editar" />
											<input type="hidden" id="id_edit" name="id" />
											
											<div class="row">
												<div class="col-md-4">
													<label class="form-label" >Nome</label>
													<input type="text" name="nome" id="nome_edit" class="form-control" />
													<span class="help-block"></span>
												</div>
												<div class="col-md-4">
													<label class="form-label" >Função</label>
													<input type="text" name="funcao" id="funcao_edit" class="form-control" />
													<span class="help-block"></span>
												</div>
                                                <div class="col-md-4">
													 <label class="form-label" >E-mail</label>
													 <div class="controls">
														  <input type="email" id="email_edit" name="email" class="form-control" maxlength="40" >
														  <span class="help-block"></span>
													 </div>
												 </div>
											</div>
											<br>
											<div class="row">
												    <div class="col-md-6">
                                                        <label class="form-label" >Grupo</label>
                                                        <div class="controls">
                                                            <select id="nivel_edit" class="form-select" name="nivel" >
                                                                <option value="">Selecione</option>
                                                                    @foreach ($grupos as $grupo)
                                                                        <option value="{{ $grupo->id }}">{{ $grupo->nome }}</option>
                                                                    @endforeach
                                                            </select>
                                                        </div>
												    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group situacao-estoque">
                                                            <label class="form-label" for="input01">Status:</label>
                                                            <div class="controls">
                                                                <div class="form-check">
                                                                    <div id="status_edit_list"></div>
                                                                </div>
                                                            </div>
                                                    </div> 
												</div>
											</div><br>
									</div>
									<div class="modal-footer">
										<button type="submit" id="btn_edit_usuarios"  class="btn btn-primary">Editar <span class="bi bi-check-lg" aria-hidden="true"></span></button>
										<a href="#" data-bs-dismiss="modal" class="btn btn-light">Fechar</a>
										</form><span class="help-block"></span>
									</div>
								</div>
							</div>
						</div>
                        <div class="modal fade" id="myModal-usuarios-edit-senha">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<h4 class="modal-title">Alterar Senha</h4>
										<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
									</div>
									<div class="container"></div>
									<div class="modal-body">
										<form id="form_usuarios_edit_senha" style="border:none">
                                            @csrf
											<input type="hidden" name="acao" value="mudar" />
											<input type="hidden" id="id_edit_senha" name="id" />
											
											<div class="row">
												<div class="col-md-12">
													<label class="form-label" >Nome</label>
													<input type="text" name="nome" id="nome_edit_senha" class="form-control" readonly="true"/>
												</div>
											</div>
											<br>
											<div class="row">
												<div class="col-md-12">
													<label class="form-label" >Nova senha</label>
													<input type="password" name="senha" id="senha_edit_senha" class="form-control" />
													<span class="help-block"></span>
												</div>
											</div>
									</div>
									<div class="modal-footer">
										<button type="submit" id="btn_edit_senha_usuarios"  class="btn btn-primary">Editar <span class="bi bi-check-lg" aria-hidden="true"></span></button>
										<a href="#" data-bs-dismiss="modal" class="btn btn-light">Fechar</a>
										</form>
										<br><span class="help-block"></span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
    </section>
    
    @include('admin.modal.modal-usuarios-add')
	
	<script>

        // Obtém o token CSRF do elemento meta no cabeçalho HTML
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
	
		/* Operações para o cadastro */
		
		$(function(){
			
			/* envia formulário add */
			
			$("#form_usuarios_add").submit(function(){

                var form = $('#form_usuarios_add')[0];
				var formData = new FormData(form);
				 
				$.ajax({
				   type:"POST",
				   url: "usuarios/cadastrar",
				   dataType : "json",
				   data: formData,
                   processData: false,
				   contentType: false,
				   beforeSend: function(){
					   clearErrors();
					   $("#btn_save_usuarios").siblings(".help-block").html("Verificando...");
					},
					success: function(response){
					   
					   if(response['status'] == 1){
						   
						   $("#myModal-usuarios-add").modal('hide');
						   swal("Sucesso!","Registro salvo com sucesso!", "success");
						   $("#form_usuarios_add")[0].reset();
						  $(".help-block").html("");
						   dt_usuarios.ajax.reload();
						   
					   }else if(response['status'] == 2){
						    swal("Error!","Houve um erro no cadastro, favor tentar novamente!", "error");
					   }else{
						   showErrorsModal(response['error_list']);
					   }
					}
				});

			   return false;
			});
			
			/* envia formulário edit */
			
			$("#form_usuarios_edit").submit(function(){

                var form = $('#form_usuarios_edit')[0];
				var formData = new FormData(form);
				 
				$.ajax({
				   type:"POST",
				   url: "usuarios/editar",
				   dataType : "json",
				   data: formData,
				   processData: false,
				   contentType: false,
				   beforeSend: function(){
					   clearErrors();
					   $("#btn_edit_usuarios").siblings(".help-block").html("Verificando...");
					},
					success: function(response){
					   
					   if(response['status'] == 1){
						   
						   $("#myModal-usuarios-edit").modal('hide');
						   swal("Sucesso!","Registro editado com sucesso!", "success");
						   $("#form_usuarios_edit")[0].reset();
						   clearErrors();
						   dt_usuarios.ajax.reload();
						   
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
			
			$("#form_usuarios_edit_senha").submit(function(){
				
				var form = $('#form_usuarios_edit_senha')[0];
				var formData = new FormData(form);
				 
				$.ajax({
				   type:"POST",
				   url: "usuarios/editarSenha",
				   dataType : "json",
				   data: formData,
				   processData: false,
				   contentType: false,
				   beforeSend: function(){
					   clearErrors();
					   $("#btn_edit_senha_usuarios").siblings(".help-block").html("Verificando...");
					},
					success: function(response){
					   
					   if(response['status'] == 1){
						   
						   $("#myModal-usuarios-edit-senha").modal('hide');
						   swal("Sucesso!","Registro editado com sucesso!", "success");
						   $("#form_usuarios_edit_senha")[0].reset();
						   clearErrors();
						   dt_usuarios.ajax.reload();
						   
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
			
			/* Botões */
			
			function active_btn_usuarios() {
				
				/* mostra modal edit */
				$(".btn-edit-usuarios").click(function(){
					$.ajax({
						type: "POST",
                        url: "usuarios/obter",
						dataType: "json",
                        data: {
                            "id": $(this).attr("usuarios_id"),
                            "_token": csrfToken
                        },
						success: function(response) {
							
							$(".help-block").html("");
							$("#form_usuarios_edit")[0].reset();
							$.each(response["input"], function(id, value) {
								$("#"+id).val(value);
							});

                            /* status */
							$("#status_edit_list").html(response["situacao"]);
							
							$("#myModal-usuarios-edit").modal('show');
						}
					})
				});

                /* mostra modal edit senha */
				$(document).on('click', '.btn-senha-usuarios', function() {
					$.ajax({
						type: "POST",
                        url: "usuarios/obterSenha",
						dataType: "json",
                        data: {
                            "id": $(this).attr("usuarios_id"),
                            "_token": csrfToken
                        },
						success: function(response) {
							
							$(".help-block").html("");
							$("#form_usuarios_edit_senha")[0].reset();
							$.each(response["input"], function(id, value) {
								$("#"+id).val(value);
							});
							
							$("#myModal-usuarios-edit-senha").modal('show');
						}
					})
				});

				/* delete registro */
				$(".btn-del-usuarios").click(function(){
					
					usuarios_id = $(this);
					swal({
						title: "Atenção!",
						text: "Deseja deletar esse registro?",
						type: "warning",
						showCancelButton: true,
						confirmButtonColor: "#d9534f",
						confirmButtonText: "Sim",
						cancelButtontext: "Não",
						closeOnConfirm: true,
						closeOnCancel: true,
					}).then((result) => {
						if (result.value) {
							$.ajax({
								type: "POST",
                                url: "usuarios/deletar",
								dataType: "json",
                                data: {
                                    "id": usuarios_id.attr("usuarios_id"),
                                    "_token": csrfToken
                                },
								success: function(response) {
									
									if(response['status'] == 2){
										
										swal("Sucesso!", "Ação executada com sucesso", "success");
										dt_usuarios.ajax.reload(); 
										
									}else if(response['status'] == 3){
										swal("Error!","Houve um erro na ação, favor tentar novamente!", "error");
									}else{
									   swal("Error!","Houve um erro no sistema, favor tentar novamente!", "error");
									}
								}
							})
						}
					})

				});
			}

			/* lista tabela */
			
			$.fn.dataTable.ext.errMode = function ( settings, helpPage, message ) { console.log(message)};
			
			var dt_usuarios = $("#dt_usuarios").DataTable({
				"oLanguage": DATATABLE_PTBR,
				"autoWidth": false,
				"processing": true,
				"serverSide": true,
				"ajax": {
					"url": "usuarios/listar",
					"type": "POST",
                    "headers": {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
				},
				"columnDefs": [
					{ targets: "no-sort", orderable: false },
					{ targets: "dt-center", className: "dt-center" },
				],
				"drawCallback": function() {
					active_btn_usuarios();
				}
			});
			
			var search_thread = null;
			$(".dataTables_filter input")
			.unbind()
			.bind("input", function(e) { 
				clearTimeout(search_thread);
				search_thread = setTimeout(function(){
					var dtable = $("#dt_usuarios").dataTable().api();
					var elem = $(".dataTables_filter input");
					return dt_usuarios.search($(elem).val()).draw();
				}, 1000);
			});
		});
		
	</script>

@endsection