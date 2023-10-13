<div class="modal fade" id="myModal-atendimentos-add">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Adicionar atendimento</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="container"></div>
            <div class="modal-body">
                <form id="form_atendimentos_add" style="border:none">
                    @csrf
                    <input type="hidden" name="acao" value="cadastrar" />
                    <input type="hidden" name="user_id" value="{{ $id_usuario }}" />

                    <div class="row">
						 <div class="col-md-12">
							<label class="form-label" >Categoria</label>
							<div class="controls">
								<select id="categoria_id" class="form-select" name="categoria_id" >
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
								<textarea class="form-control" id="textarea" rows="5" name="descricao" ></textarea>
                                <span class="help-block"></span>
							</div>
						 </div>
                    </div><br>

                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label" >Prazo</label>
                            <div class="controls">
                                <input id="dt_prazo" class="form-control" type="date" name="dt_prazo">
								<span class="help-block"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
							<label class="form-label" >Status</label>
							<div class="controls">
								<select id="status" class="form-select" name="status" >
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
                <button type="submit" id="btn_save_atendimentos"  class="btn btn-primary">Salvar <span class="bi bi-check-lg"></span></button>
                <a href="#" data-bs-dismiss="modal" class="btn btn-light">Fechar</a>
                </form>
				<span class="help-block"></span>
            </div>
        </div>
    </div>
</div>