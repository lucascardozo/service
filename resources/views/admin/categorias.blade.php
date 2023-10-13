@extends('admin.layouts.basico')

@section("title","Categorias")

@section('conteudo')

    @php
    /*
    * Página categorias
    * Autor : Lucar Cardozo
    *  
    */

    if ($nivel != 1) {
        return redirect('home');
    }

    @endphp

    <div class="pagetitle">
      <h1>Categorias</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="home">Home</a></li>
          <li class="breadcrumb-item active">Categorias</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    
    <section class="section">
		<div class="row">
			<div class="col-lg-12">
				<?php if($nivel == 1){ ?>  
					<a href="#" data-bs-toggle="modal" data-bs-target="#myModal-categorias-add" class="btn btn-outline btn-primary" >Adicionar novo <i class="bi bi-plus-lg"></i></a>
				<?php } ?>
				<br /><br />
				<div class="card">
					<div class="card-body">
					  <br /><br />
					  <!-- Table with stripped rows -->
					  <table id="dt_categorias" class="table" style="width:100%;">
						<thead>
						  <tr class="tableheader">
							<th scope="col" >Cód.</th>
							<th scope="w-100" >Nome</th>
							<th class="dt-center no-sort" scope="col" >Ação</th>
						  </tr>
						</thead>
						<tbody></tbody>
					  </table>
					  <!-- End Table with stripped rows -->
						<div class="modal fade" id="myModal-categorias-edit">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<h4 class="modal-title">Alterar categoria</h4>
										<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
									</div>
									<div class="container"></div>
									<div class="modal-body">
										<form id="form_categorias_edit" style="border:none">
                                            @csrf
											<input type="hidden" name="acao" value="editar" />
											<input type="hidden" id="id_edit" name="id" />
											
											<label class="form-label" >Nome</label>
											<input type="text" name="nome" id="nome_edit" class="form-control" />
											<span class="help-block"></span>
											
											
									</div>
									<div class="modal-footer">
										<button type="submit" id="btn_edit_categorias"  class="btn btn-primary">Editar <span class="bi bi-check-lg" aria-hidden="true"></span></button>
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
    
    @include('admin.modal.modal-categorias-add')
	
	<script>

        // Obtém o token CSRF do elemento meta no cabeçalho HTML
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
	
		/* Operações para o cadastro */
		
		$(function(){
			
			/* envia formulário add */
			
			$("#form_categorias_add").submit(function(){
				 
				$.ajax({
				   type:"POST",
				   url: "categorias/cadastrar",
				   dataType : "json",
				   data: $(this).serialize(),
				   beforeSend: function(){
					   clearErrors();
					   $("#btn_save_categorias").siblings(".help-block").html("Verificando...");
					},
					success: function(response){
					   
					   if(response['status'] == 1){
						   
						   $("#myModal-categorias-add").modal('hide');
						   swal("Sucesso!","Registro salvo com sucesso!", "success");
						   $("#form_categorias_add")[0].reset();
						  $(".help-block").html("");
						   dt_categorias.ajax.reload();
						   
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
			
			$("#form_categorias_edit").submit(function(){
				 
				$.ajax({
				   type:"POST",
				   url: "categorias/editar",
				   dataType : "json",
				   data: $(this).serialize(),
				   beforeSend: function(){
					   clearErrors();
					   $("#btn_edit_categorias").siblings(".help-block").html("Verificando...");
					},
					success: function(response){
					   
					   if(response['status'] == 1){
						   
						   $("#myModal-categorias-edit").modal('hide');
						   swal("Sucesso!","Registro editado com sucesso!", "success");
						   $("#form_categorias_edit")[0].reset();
						   clearErrors();
						   dt_categorias.ajax.reload();
						   
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
			
			function active_btn_categorias() {
				
				/* mostra modal edit */
				$(".btn-edit-categorias").click(function(){
					$.ajax({
						type: "POST",
                        url: "categorias/obter",
						dataType: "json",
                        data: {
                            "id": $(this).attr("categorias_id"),
                            "_token": csrfToken
                        },
						success: function(response) {
							
							$(".help-block").html("");
							$("#form_categorias_edit")[0].reset();
							$.each(response["input"], function(id, value) {
								$("#"+id).val(value);
							});
							
							$("#myModal-categorias-edit").modal('show');
						}
					})
				});

				/* delete registro */
				$(".btn-del-categorias").click(function(){
					
					categorias_id = $(this);
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
                                url: "categorias/deletar",
								dataType: "json",
                                data: {
                                    "id": categorias_id.attr("categorias_id"),
                                    "_token": csrfToken
                                },
								success: function(response) {
									
									if(response['status'] == 2){
										
										swal("Sucesso!", "Ação executada com sucesso", "success");
										dt_categorias.ajax.reload(); 
										
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
			
			var dt_categorias = $("#dt_categorias").DataTable({
				"oLanguage": DATATABLE_PTBR,
				"autoWidth": false,
				"processing": true,
				"serverSide": true,
				"ajax": {
					"url": "categorias/listar",
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
					active_btn_categorias();
				}
			});
			
			var search_thread = null;
			$(".dataTables_filter input")
			.unbind()
			.bind("input", function(e) { 
				clearTimeout(search_thread);
				search_thread = setTimeout(function(){
					var dtable = $("#dt_categorias").dataTable().api();
					var elem = $(".dataTables_filter input");
					return dt_categorias.search($(elem).val()).draw();
				}, 1000);
			});
		});
		
	</script>

@endsection