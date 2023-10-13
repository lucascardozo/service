@extends('admin.layouts.basico')

@section("title","Grupos")

@section('conteudo')

    @php
    /*
    * Página Grupos
    * Autor : Lucar Cardozo
    *  
    */

    if($nivel != 1){
        echo "<script>window.location.replace('home');</script>";
    }

    @endphp

    <div class="pagetitle">
      <h1>Grupos</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="home">Home</a></li>
          <li class="breadcrumb-item active">Grupos</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    
    <section class="section">
		<div class="row">
			<div class="col-lg-12">
				<?php if($nivel == 1){ ?>  
					<a href="#" data-bs-toggle="modal" data-bs-target="#myModal-grupos-add" class="btn btn-outline btn-primary" >Adicionar novo <i class="bi bi-plus-lg"></i></a>
				<?php } ?>
				<br /><br />
				<div class="card">
					<div class="card-body">
					  <br /><br />
					  <!-- Table with stripped rows -->
					  <table id="dt_grupos" class="table" style="width:100%;">
						<thead>
						  <tr class="tableheader">
							<th scope="col" >Cód.</th>
							<th scope="w-100" >Nome</th>
							<th scope="w-100" >Descrição</th>
							<th class="dt-center no-sort" scope="col" >Ação</th>
						  </tr>
						</thead>
						<tbody></tbody>
					  </table>
					  <!-- End Table with stripped rows -->
						<div class="modal fade" id="myModal-grupos-edit">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<h4 class="modal-title">Alterar grupo</h4>
										<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
									</div>
									<div class="container"></div>
									<div class="modal-body">
										<form id="form_grupos_edit" style="border:none">
                                            @csrf
											<input type="hidden" name="acao" value="editar" />
											<input type="hidden" id="id_edit" name="id" />
											
											<label class="form-label" >Nome</label>
											<input type="text" name="nome" id="nome_edit" class="form-control" />
											<span class="help-block"></span>
											</br>
					
											<label>Descrição</label>
											<textarea class="form-control" id="descricao_edit" rows="5" name="descricao" ></textarea>
											
											
									</div>
									<div class="modal-footer">
										<button type="submit" id="btn_edit_grupos"  class="btn btn-primary">Editar <span class="bi bi-check-lg" aria-hidden="true"></span></button>
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
    
    @include('admin.modal.modal-grupos-add')
	
	<script>

        // Obtém o token CSRF do elemento meta no cabeçalho HTML
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
	
		/* Operações para o cadastro */
		
		$(function(){
			
			/* envia formulário add */
			
			$("#form_grupos_add").submit(function(){
				 
				$.ajax({
				   type:"POST",
				   url: "grupos/cadastrar",
				   dataType : "json",
				   data: $(this).serialize(),
				   beforeSend: function(){
					   clearErrors();
					   $("#btn_save_grupos").siblings(".help-block").html("Verificando...");
					},
					success: function(response){
					   
					   if(response['status'] == 1){
						   
						   $("#myModal-grupos-add").modal('hide');
						   swal("Sucesso!","Registro salvo com sucesso!", "success");
						   $("#form_grupos_add")[0].reset();
						  $(".help-block").html("");
						   dt_grupos.ajax.reload();
						   
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
			
			$("#form_grupos_edit").submit(function(){
				 
				$.ajax({
				   type:"POST",
				   url: "grupos/editar",
				   dataType : "json",
				   data: $(this).serialize(),
				   beforeSend: function(){
					   clearErrors();
					   $("#btn_edit_grupos").siblings(".help-block").html("Verificando...");
					},
					success: function(response){
					   
					   if(response['status'] == 1){
						   
						   $("#myModal-grupos-edit").modal('hide');
						   swal("Sucesso!","Registro editado com sucesso!", "success");
						   $("#form_grupos_edit")[0].reset();
						   clearErrors();
						   dt_grupos.ajax.reload();
						   
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
			
			function active_btn_grupos() {
				
				/* mostra modal edit */
				$(".btn-edit-grupos").click(function(){
					$.ajax({
						type: "POST",
                        url: "grupos/obter",
						dataType: "json",
                        data: {
                            "id": $(this).attr("grupos_id"),
                            "_token": csrfToken
                        },
						success: function(response) {
							
							$(".help-block").html("");
							$("#form_grupos_edit")[0].reset();
							$.each(response["input"], function(id, value) {
								$("#"+id).val(value);
							});
							
							$("#myModal-grupos-edit").modal('show');
						}
					})
				});

				/* delete registro */
				$(".btn-del-grupos").click(function(){
					
					grupos_id = $(this);
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
                                url: "grupos/deletar",
								dataType: "json",
                                data: {
                                    "id": grupos_id.attr("grupos_id"),
                                    "_token": csrfToken
                                },
								success: function(response) {
									
									if(response['status'] == 2){
										
										swal("Sucesso!", "Ação executada com sucesso", "success");
										dt_grupos.ajax.reload(); 
										
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
			
			var dt_grupos = $("#dt_grupos").DataTable({
				"oLanguage": DATATABLE_PTBR,
				"autoWidth": false,
				"processing": true,
				"serverSide": true,
				"ajax": {
					"url": "grupos/listar",
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
					active_btn_grupos();
				}
			});
			
			var search_thread = null;
			$(".dataTables_filter input")
			.unbind()
			.bind("input", function(e) { 
				clearTimeout(search_thread);
				search_thread = setTimeout(function(){
					var dtable = $("#dt_grupos").dataTable().api();
					var elem = $(".dataTables_filter input");
					return dt_grupos.search($(elem).val()).draw();
				}, 1000);
			});
		});
		
	</script>

@endsection