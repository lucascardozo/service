<div class="modal fade" id="myModal-usuarios-add">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Adicionar usuário</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="container"></div>
            <div class="modal-body">
                <form id="form_usuarios_add" style="border:none">
                    @csrf
                    <input type="hidden" name="acao" value="cadastrar" />
					
					<div class="row">
						<div class="col-md-4">
							<label class="form-label" >Nome</label>
							<input type="text" name="nome" id="nome" class="form-control" />
							<span class="help-block"></span>
						</div>
						<div class="col-md-4">
							<label class="form-label" >Função</label>
							<input type="text" name="funcao" id="funcao" class="form-control" />
							<span class="help-block"></span>
						</div>
						<div class="col-md-4">
							 <label class="form-label" >E-mail</label>
							 <div class="controls">
								  <input type="email" id="email" name="email" class="form-control" maxlength="40" >
								  <span class="help-block"></span>
							 </div>
						 </div>
					</div>
					<br>
					<div class="row">
						 <div class="col-md-6">
							<label class="form-label" >Grupo</label>
							<div class="controls">
								<select id="nivel" class="form-select" name="nivel" >
									<option value="">Selecione</option>
										@foreach ($grupos as $grupo)
                                            <option value="{{ $grupo->id }}">{{ $grupo->nome }}</option>
                                        @endforeach
								</select>
							</div>
						 </div>
						<div class="col-md-6">
							<label class="form-label" >Senha</label>
							<input type="password" name="senha" id="senha" class="form-control" />
							<span class="help-block"></span>
						</div>
					</div>
            </div>
            <div class="modal-footer">	
                <button type="submit" id="btn_save_usuarios"  class="btn btn-primary">Salvar <span class="bi bi-check-lg"></span></button>
                <a href="#" data-bs-dismiss="modal" class="btn btn-light">Fechar</a>
                </form>
				<span class="help-block"></span>
            </div>
        </div>
    </div>
</div>