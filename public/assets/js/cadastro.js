/* Operações para o cadastro */
		
$(function(){
	
	$("#cmdContinuarmgs").hide();

	/* envia formulário add */

	$("#form-cadastro").submit(function(ev){
			
		ev.preventDefault();
		
		$.ajax({
			type:"POST",
			url: "src/Controller/demandas/demandasCadastrar.php",
			dataType : "json",
			data: $(this).serialize(),
			beforeSend: function(){
				clearErrors();
				$("#cmdContinuar").siblings(".help-block").html("Verificando...");
				$("#cmdContinuar").prop('disabled',true);
			},
			success: function(response){

				if(response['status'] == 1){
					
					var protocolo = response['protocolo'];
					
					swal({
					  icon: 'success',
					  title: 'Sucesso!',
					  text: "Seu protocolo de acompanhamento é "+protocolo+", Aguarde nosso contato!",
					  footer: '<a href="#" class="btn btn-info"><span class="bi bi-telephone"></span> Receber por SMS</a>&nbsp;<a href="protocolo?id='+protocolo+'" class="btn btn-secondary" target="_blank"><span class="bi bi-printer"></span> Imprimir</a>'
					});
					
					$("#form-cadastro")[0].reset();
					$(".help-block").html("");
					$("#cmdContinuar").prop('disabled',false);

				}else if(response['status'] == 2){
					swal("Error!","Houve um erro no cadastro, favor tentar novamente!", "error");
					$("#cmdContinuar").prop('disabled',false);
				}else{
					showErrorsModal(response['error_list']);
					$("#cmdContinuar").prop('disabled',false);
				}
			}
		});
	});
});

$(function(){
	$('#bairro_demanda').change(function(){				
		if( $(this).val() ) {
			$('#id_microregiao').hide();
			$.getJSON('admin/json/verifica_microregiao.ajax.php?search=',{bairro_demanda: $(this).val(), ajax: 'true'}, function(j){
				var options = '<option value="">Selecione</option>';	
				for (var i = 0; i < j.length; i++) {
						options += '<option value="' + j[i].id + '">' + j[i].nome + '</option>';
				}	
				$('#id_microregiao').html(options).show();
			});
		} else {
			$('#id_microregiao').html('<option value="">Selecione</option>');
		}
	});
});