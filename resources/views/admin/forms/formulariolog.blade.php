<div class="card">
    <div class="card-body">
        <h3 class="card-title">Consulte um log</h3>
        <form class="form-search" method="post" action="{{ route("admin.logs")}}" >
            @csrf
            <fieldset>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label" >Dt. cadastro</label>
                            <div class="controls">
                                <div class="input-group">
                                    <input id="date" class="form-control" type="date" name="periodo">
                                </div>	   
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <label class="form-label" >Descrição</label>
                        <div class="controls">
                          <input type="text" class="form-control" id="descricao" name="descricao" />
                        </div>
                    </div>
                    <div class="col-md-2">
                        <!-- Botões -->
                        <label class="form-label" for="botao"></label>	
                        <div class="controls">
                            <button type="submit" style="margin-top:6px;" class="btn btn-primary">Buscar <span class="bi bi-search" aria-hidden="true"></span></button>
                        </div>
                    </div>	
                </div>
            </fieldset>
        </form>
    </div>
</div>	
<!-- Fim do Formulário de Busca -->