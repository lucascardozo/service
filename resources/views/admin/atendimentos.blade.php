@extends('admin.layouts.basico')

@section("title","Atendimentos")

@section('conteudo')

    @php
    /*
    * Página atendimentos
    * Autor : Lucar Cardozo
    *  
    */

    if ($nivel != 1) {
        return redirect('home');
    }

    @endphp

    <div class="pagetitle">
      <h1>Atendimentos</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="home">Home</a></li>
          <li class="breadcrumb-item active">Atendimentos</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    
    <section class="section">
		<div class="row">
			<div class="col-lg-12">
				<?php if($nivel == 1){ ?>  
					<a href="#" data-bs-toggle="modal" data-bs-target="#myModal-atendimentos-add" class="btn btn-outline btn-primary" >Adicionar novo <i class="bi bi-plus-lg"></i></a>
				<?php } ?>
				<br /><br />
				<div class="card">
					<div class="card-body">
					  <br /><br />
					  <!-- Table with stripped rows -->
					  <table id="dt_atendimentos" class="table" style="width:100%;">
						<thead>
						  <tr class="tableheader">
							<th scope="col" >Cód.</th>
							<th scope="w-100" >Categoria</th>
                            <th scope="w-100" >Prazo</th>
                            <th scope="w-100" >Status</th>
							<th class="dt-center no-sort" scope="col" >Ação</th>
						  </tr>
						</thead>
						<tbody></tbody>
					  </table>
					  <!-- End Table with stripped rows -->
						<div class="modal fade" id="myModal-atendimentos-edit">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<h4 class="modal-title">Alterar atendimento</h4>
										<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
									</div>
									<div class="container"></div>
									<div class="modal-body">
										<form id="form_atendimentos_edit" style="border:none">
                                            @csrf
											<input type="hidden" name="acao" value="editar" />
											<input type="hidden" id="id_edit" name="id" />
											<input type="hidden" id="user_id_edit" name="user_id" value="{{ $id_usuario }}" />

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label class="form-label" >Categoria</label>
                                                    <div class="controls">
                                                        <select id="categoria_id_edit" class="form-select" name="categoria_id" >
                                                            <option value="">Selecione</option>
                                                                @foreach ($categorias as $categoria)
                                                                    <option value="{{ $categoria->id }}">{{ $categoria->nome }}</option>
                                                                @endforeach
                                                        </select>
                                                        <span class="help-block"></span>
                                                    </div>
                                                </div>
                                            </div><br>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label class="form-label" >Descrição</label>
                                                    <div class="controls">
                                                        <textarea class="form-control" id="descricao_edit" rows="5" name="descricao" ></textarea>
                                                        <span class="help-block"></span>
                                                    </div>
                                                </div>
                                            </div><br>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label class="form-label" >Prazo</label>
                                                    <div class="controls">
                                                        <input id="dt_prazo_edit" class="form-control" type="date" name="dt_prazo">
                                                        <span class="help-block"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label" >Status</label>
                                                    <div class="controls">
                                                        <select id="status_edit" class="form-select" name="status" >
                                                            <option value="">Selecione</option>
                                                            <option value="Pendente">Pendente</option>
                                                            <option value="Concluido">Concluido</option>
                                                        </select>
                                                        <span class="help-block"></span>
                                                    </div>
                                                </div> 
                                            </div><br>
									</div>
									<div class="modal-footer">
										<button type="submit" id="btn_edit_atendimentos"  class="btn btn-primary">Editar <span class="bi bi-check-lg" aria-hidden="true"></span></button>
										<a href="#" data-bs-dismiss="modal" class="btn btn-light">Fechar</a>
										</form><span class="help-block"></span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
    </section>
    
    @include('admin.modal.modal-atendimentos-add')
	
	<script>

        // Obtém o token CSRF do elemento meta no cabeçalho HTML
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
	
		/* Operações para o cadastro */
		
		$(function(){
			
			/* envia formulário add */
			
			$("#form_atendimentos_add").submit(function(){
				 
				$.ajax({
				   type:"POST",
				   url: "atendimentos/cadastrar",
				   dataType : "json",
				   data: $(this).serialize(),
				   beforeSend: function(){
					   clearErrors();
					   $("#btn_save_atendimentos").siblings(".help-block").html("Verificando...");
					},
					success: function(response){
					   
					   if(response['status'] == 1){
						   
						   $("#myModal-atendimentos-add").modal('hide');
						   swal("Sucesso!","Registro salvo com sucesso!", "success");
						   $("#form_atendimentos_add")[0].reset();
						  $(".help-block").html("");
						   dt_atendimentos.ajax.reload();
						   
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
			
			$("#form_atendimentos_edit").submit(function(){
				 
				$.ajax({
				   type:"POST",
				   url: "atendimentos/editar",
				   dataType : "json",
				   data: $(this).serialize(),
				   beforeSend: function(){
					   clearErrors();
					   $("#btn_edit_atendimentos").siblings(".help-block").html("Verificando...");
					},
					success: function(response){
					   
					   if(response['status'] == 1){
						   
						   $("#myModal-atendimentos-edit").modal('hide');
						   swal("Sucesso!","Registro editado com sucesso!", "success");
						   $("#form_atendimentos_edit")[0].reset();
						   clearErrors();
						   dt_atendimentos.ajax.reload();
						   
					   }else if(response['status'] == 2){
						    swal("Error!","Houve um erro na ação, favor tentar novamente!", "error");
					   }else{
						   showErrorsModal(response['error_list']);
					   }
					}
				});

			   return false;
			});
			
			/* Botões */
			
			function active_btn_atendimentos() {
				
				/* mostra modal edit */
				$(".btn-edit-atendimentos").click(function(){
					$.ajax({
						type: "POST",
                        url: "atendimentos/obter",
						dataType: "json",
                        data: {
                            "id": $(this).attr("atendimentos_id"),
                            "_token": csrfToken
                        },
						success: function(response) {
							
							$(".help-block").html("");
							$("#form_atendimentos_edit")[0].reset();
							$.each(response["input"], function(id, value) {
								$("#"+id).val(value);
							});
							
							$("#myModal-atendimentos-edit").modal('show');
						}
					})
				});

				/* delete registro */
				$(".btn-del-atendimentos").click(function(){
					
					atendimentos_id = $(this);
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
                                url: "atendimentos/deletar",
								dataType: "json",
                                data: {
                                    "id": atendimentos_id.attr("atendimentos_id"),
                                    "_token": csrfToken
                                },
								success: function(response) {
									
									if(response['status'] == 2){
										
										swal("Sucesso!", "Ação executada com sucesso", "success");
										dt_atendimentos.ajax.reload(); 
										
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
			
			var dt_atendimentos = $("#dt_atendimentos").DataTable({
				"oLanguage": DATATABLE_PTBR,
				"autoWidth": false,
				"processing": true,
				"serverSide": true,
				"ajax": {
					"url": "atendimentos/listar",
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
					active_btn_atendimentos();
				}
			});
			
			var search_thread = null;
			$(".dataTables_filter input")
			.unbind()
			.bind("input", function(e) { 
				clearTimeout(search_thread);
				search_thread = setTimeout(function(){
					var dtable = $("#dt_atendimentos").dataTable().api();
					var elem = $(".dataTables_filter input");
					return dt_atendimentos.search($(elem).val()).draw();
				}, 1000);
			});
		});
		
	</script>

@endsection