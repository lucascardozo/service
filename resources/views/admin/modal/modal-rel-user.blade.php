<div class="modal fade" id="myModal-rel-user">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
               <h4 class="modal-title">Relatório de usuários</h4>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="container"></div>
            <div class="modal-body">
                <form name="form_rel_user" method="post" action="{{ route("admin.report.user") }}">
                    @csrf
					<div class="row">
                         <div class="col-md-6">
                             <label class="form-label" >Dt.Inicial</label>
                             <div class="controls">
                                <input id="data_inicial" class="form-control" type="date" name="data_inicial">
								<span class="help-block"></span>
                             </div>
                         </div>
                         <div class="col-md-6">
                             <label class="form-label" >Dt.Final</label>
                             <div class="controls">
                                <input id="data_final" class="form-control" type="date" name="data_final">
								<span class="help-block"></span>
                             </div>
                         </div>
                    </div>
				    <br>
					<div class="row">
                         <div class="col-md-12">
                             <label class="form-label" >Grupo</label>
                             <div class="controls">
                                 <select class="form-select" name="grupo" >
                                     <option value="">Selecione</option>
                                     @foreach ($lista_grupos as $item)
                                        <option value="{{ $item->id }}">{{ $item->nome }}</option>
                                     @endforeach
                                 </select>
								  <span class="help-block"></span>
                             </div>
                         </div>
					</div>
					<br>
					<div class="row">
                         <div class="col-md-12">
                             <label class="form-label" >Status</label>
                             <div class="controls">
                                 <select class="form-select" name="status" >
                                    <option value="">Selecione</option>
                                    <option value="Ativo">Ativo</option>
                                    <option value="Inativo">Inativo</option>
                                 </select>
								  <span class="help-block"></span>
                             </div>
                         </div>
					</div>
					<br>
					<div class="row">
						<div class="col-md-12">				
							<div class="form-group">
								<input type="submit" class="btn btn-primary" value="Gerar" />
								<a href="#" style="float:right;" data-bs-dismiss="modal" class="btn btn-light">Fechar</a>
							</div>
						</div>
					</div>	
				</form>
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>