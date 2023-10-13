<div class="modal fade" id="myModal-categorias-add">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Adicionar categoria</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="container"></div>
            <div class="modal-body">
                <form id="form_categorias_add" style="border:none">
                    @csrf
                    <input type="hidden" name="acao" value="cadastrar" />
                    <label>Nome</label>
                    <input type="text" name="nome" id="nome" class="form-control" />
					<span class="help-block"></span>
                    
            </div>
            <div class="modal-footer">	
                <button type="submit" id="btn_save_categorias"  class="btn btn-primary">Salvar <span class="bi bi-check-lg"></span></button>
                <a href="#" data-bs-dismiss="modal" class="btn btn-light">Fechar</a>
                </form>
				<span class="help-block"></span>
            </div>
        </div>
    </div>
</div>