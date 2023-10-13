/* URL BASE DO PROJETO*/

const BASE_URL = "#";

const DATATABLE_PTBR = {
    "sEmptyTable": "Nenhum registro encontrado",
    "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
    "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
    "sInfoFiltered": "(Filtrados de _MAX_ registros)",
    "sInfoPostFix": "",
    "sInfoThousands": ".",
    "sLengthMenu": "_MENU_ resultados por página",
    "sLoadingRecords": "Carregando...",
    "sProcessing": "Processando...",
    "sZeroRecords": "Nenhum registro encontrado",
    "sSearch": "Pesquisar",
    "oPaginate": {
        "sNext": "Próximo",
        "sPrevious": "Anterior",
        "sFirst": "Primeiro",
        "sLast": "Último"
    },
    "oAria": {
        "sSortAscending": ": Ordenar colunas de forma ascendente",
        "sSortDescending": ": Ordenar colunas de forma descendente"
    }
}

/* FUNÇÕES ÚTEIS */

function clearErrors(){
    
    $(".is-invalid").removeClass("is-invalid");
    $(".help-block").html();
}

function showErrors(error_list){
    clearErrors();
    
    $.each(error_list, function(id,message){
        $(id).addClass("is-invalid");
        $(id).siblings(".help-block").html(message);
    })
}

function showErrorsModal(error_list){
    clearErrors();
    
    $.each(error_list, function(id,message){
        $(id).addClass("is-invalid");
		$(id).siblings(".help-block").addClass("invalid-feedback");
        $(id).siblings(".help-block").html(message);
    })
}

function loadingImg(message = ""){
    return "<i class='fa fa-circle-o-notch fa-spin'></i>&nbsp;"+ message;
}

function moeda(z){  
    v = z.value;
    v=v.replace(/\D/g,"");  //permite digitar apenas números
    v=v.replace(/[0-9]{12}/,"");   //limita pra máximo 999.999.999,99
    v=v.replace(/(\d{1})(\d{1})$/,"$1.$2");	//coloca virgula antes dos últimos 2 digitos
    z.value = v;     
}

function justNumeros(z){
    v = z.value;
    v = v.replace(/\D/g,"")
    z.value = v;
}
