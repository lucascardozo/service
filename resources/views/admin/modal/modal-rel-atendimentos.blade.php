<div class="modal fade" id="myModal-rel-atendimentos">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
               <h4 class="modal-title">Relatório de atendimentos</h4>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="container"></div>
            <div class="modal-body">
                <form name="form_rel_atendimentos" method="post" action="{{ route("admin.report.atendimentos") }}">
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
                             <label class="form-label" >Categoria</label>
                             <div class="controls">
                                 <select class="form-select" name="categoria_id" >
                                     <option value="">Selecione</option>
                                     @foreach ($lista_categorias as $item)
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
                                    <option value="Pendente">Pendente</option>
                                    <option value="Concluido">Concluido</option>
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