@php
/*
 * Página Inicial do Projeto
 * Autor : Lucar Cardozo
 *  
*/
@endphp

@extends('admin.layouts.basico')

@section('conteudo')

    <!-- Início do conteúdo -->

    <!-- Inicio Alertas -->
    <div id="alertas"></div>
    <!-- Fim Alertas -->

    <!-- inicio dashboard -->
    <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="home">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-12">
          <div class="row">

            <!-- Sales Card -->
            <div class="col-md-3">
              <div class="card info-card sales-card">

                <div class="card-body">
                  <h5 class="card-title">Atendimentos</h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-journal-text"></i>
                    </div>
                    <div class="ps-3">
                      <h6 id="qtd_atendimentos"></h6>
                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Sales Card -->

            <!-- Revenue Card -->
             <div class="col-md-3">
              <div class="card info-card revenue-card">

                <div class="card-body">
                  <h5 class="card-title">Concluidos <span></span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-journal-text"></i>
                    </div>
                    <div class="ps-3">
                       <h6 id="qtd_atendimentos_concluidos"></h6>
                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Revenue Card -->

            <!-- Customers Card -->
             <div class="col-md-3">

              <div class="card info-card customers-card">

                <div class="card-body">
                  <h5 class="card-title">Pendentes <span></span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-journal-text"></i>
                    </div>
                    <div class="ps-3">
                       <h6 id="qtd_atendimentos_pendentes"></h6>
                    </div>
                  </div>

                </div>
              </div>

            </div><!-- End Customers Card -->
			
			 <!-- Customers Card -->
             <div class="col-md-3">

              <div class="card info-card sales-card">

                <div class="card-body">
                  <h5 class="card-title">Hoje <span></span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-journal-text"></i>
                    </div>
                    <div class="ps-3">
                       <h6 id="qtd_atendimentos_hoje"></h6>
                    </div>
                  </div>

                </div>
              </div>

            </div><!-- End Customers Card -->

          </div>
        </div><!-- End Left side columns -->

        <!-- Right side columns -->
        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                      <div class="card-body">
                        <h5 class="card-title">Atendimentos por Mês</h5>

                        <!-- Bar Chart -->
                        <div id="barChart" style="min-height: 400px;" class="echart"></div>
						<script>
							
							$(function(){
								
							   var myChartStatus = echarts.init(document.querySelector("#barChart"));
							   
								$.ajax ({
									async: true,
									url: "{{ route("admin.charts.atendimentos.mes") }}", 
									dataType: "json", 
									success: function(dados) {
										
										console.log(dados);
										
										var indice = [];
										var values = [];
										
										for (var i = 0; i < dados.length; i++) {
											indice.push(dados[i].name);
											values.push(dados[i].value);
										}	
										
										var option = {
											tooltip: {
											  trigger: 'item'
											},
											xAxis: {
												type: 'category',
												data: indice
											},
											yAxis: {
												type: 'value'
											},
											series: [{
												name: 'Mês',
												type: 'bar',
												data: values
											}]
										};
													  
										if (option != null && typeof option === "object") {
											myChartStatus.setOption(option, true);
										}
									}
								});
							});
						</script>
                        <!-- End Bar Chart -->
                      </div>
                    </div>
                  </div>
                
				  <div class="col-lg-6">
                    <div class="card">
                      <div class="card-body">
                        <h5 class="card-title">Atendimentos por Categoria</h5>

                        <!-- Pie Chart -->
                        <div id="pieChart-service" style="min-height: 400px;" class="echart"></div>
						<script>
							
							$(function(){
								
							   var myChartStatus = echarts.init(document.querySelector("#pieChart-service"));
							   
								$.ajax ({
									async: true,
									url: "{{ route("admin.charts.atendimentos.categorias") }}", 
									dataType: "json", 
									success: function(dados) {
										
										console.log(dados);
										
										var option = {
											title: {
											  text: '',
											  subtext: '',
											  left: 'center'
											},
											tooltip: {
											  trigger: 'item'
											},
											series: [{
											  name: 'Serviços',
											  type: 'pie',
											  radius: '50%',
											  data: dados,
											  emphasis: {
												itemStyle: {
												  shadowBlur: 10,
												  shadowOffsetX: 0,
												  shadowColor: 'rgba(0, 0, 0, 0.5)'
												}
											  }
											}]
										}
													  
										if (option != null && typeof option === "object") {
											myChartStatus.setOption(option, true);
										}
									}
								});
							});
						</script>
                        <!-- End Pie Chart -->
                      </div>
                    </div>
				</div>
                
            </div>
        </div>  
    </div> 
    </section>
    <script>

        $(function(){

            /* busca dados */

            $.ajax({
                url: "{{ route("admin.charts.atendimentos") }}", 
                type:"GET",
                dataType : "json",
                success: function(resposta){

                    $("#qtd_atendimentos").html(resposta['qtd_atendimentos']);
                    $("#qtd_atendimentos_concluidos").html(resposta['qtd_atendimentos_concluidos']);
                    $("#qtd_atendimentos_pendentes").html(resposta['qtd_atendimentos_pendentes']);
                    $("#qtd_atendimentos_hoje").html(resposta['qtd_atendimentos_hoje']);
                }
            });
        });
    </script>

<!-- fim dashboard -->
<!-- fim do conteúdo -->

@endsection
