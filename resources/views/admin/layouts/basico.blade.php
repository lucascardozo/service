<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1.0" name="viewport">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.nome') }}</title>
        <meta name="description" content="{{ config('app.descricao') }}">
        <meta name="author" content="{{ config('app.autor') }}">
        <meta name="keywords" content="{{ config('app.keywords') }}">
        
        <!-- Ícones -->
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/ico/apple-touch-icon.png?vs=01') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/ico/favicon-32x32.png?vs=01') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/ico/favicon-16x16.png?vs=01') }}">
        <link rel="manifest" href="{{ asset('assets/ico/site.webmanifest?vs=01') }}">

        <!-- Google Fonts -->
        <link href="https://fonts.gstatic.com" rel="preconnect">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

        <!-- Vendor CSS Files -->
        <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">
        
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/farhadmammadli/bootstrap-select@main/css/bootstrap-select.min.css">
		
        <!-- DataTables CSS -->
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.11.3/datatables.min.css"/>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">
		
        <!-- Template Main CSS File -->
        <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
        <style>
			.card-title span {
				font-size: 10px !important;
			}
			.clean{
				margin-top: 20px;
			}
			.btn-circle {
				width: 30px;
				height: 30px;
				padding: 6px 0px;
				border-radius: 15px;
				text-align: center;
				font-size: 12px;
				line-height: 1.42857;
			}
        </style>
        
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="{{ asset('assets/js/jquery-ui.js') }}"></script>
        
        <!-- Estilo CSS calendário datetime -->
        <script type="text/javascript" src="{{ asset('assets/js/pt-BR.js') }}"></script>
        <script src="{{ asset('assets/js/moment.js') }}"></script>
        <script src="{{ asset('assets/js/bootstrap-datetimepicker.js') }}"></script>
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}" />  
        
        <!-- =======================================================
        * Template Name: NiceAdmin - v2.1.0
        * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
        * Author: BootstrapMade.com
        * License: https://bootstrapmade.com/license/
        ======================================================== -->
    </head>
    <body>
      <!-- ======= Header ======= -->
      <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
          <a href="home" class="logo d-flex align-items-center">
            <img style="max-height: 55px;" src="{{ asset('assets/img/logo.png?vs=02') }}" alt="{{ config('app.nome') }}">
            <span class="d-none d-lg-block"></span>
          </a>
          <i class="bi bi-list toggle-sidebar-btn"></i>
        </div><!-- End Logo -->

        <nav class="header-nav ms-auto">
          <ul class="d-flex align-items-center">
            <li class="nav-item dropdown pe-3">

              <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                <img src="{{ $foto }}" alt="Profile" class="rounded-circle">
                <span class="d-none d-md-block dropdown-toggle ps-2">{{ $nome_usuario }}</span>
              </a><!-- End Profile Iamge Icon -->

              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                <li class="dropdown-header">
                  <h6>{{ $nome_usuario }}</h6>
                  <span>{{ $nome_grupo }}</span>
                </li>
                <li>
                  <hr class="dropdown-divider">
                </li>
                <li>
                  <a class="dropdown-item d-flex align-items-center" href="{{ route("admin.perfil") }}">
                    <i class="bi bi-person"></i>
                    <span>Meu Perfil</span>
                  </a>
                </li>
                <li>
                  <hr class="dropdown-divider">
                </li>
                <li>
                  <a class="dropdown-item d-flex align-items-center" href="{{ route('admin.sair') }}">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Sair</span>
                  </a>
                </li>

              </ul><!-- End Profile Dropdown Items -->
            </li><!-- End Profile Nav -->

          </ul>
        </nav><!-- End Icons Navigation -->
      </header><!-- End Header -->

      <!-- ======= Sidebar ======= -->
      <aside id="sidebar" class="sidebar">

        <ul class="sidebar-nav" id="sidebar-nav">

            <li class="nav-item">
                <a id="home" class="nav-link collapsed" href="home">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
                </a>
            </li><!-- End Dashboard Nav -->
		
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#tables-cad" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-menu-button-wide"></i><span>Cadastros</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="tables-cad" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="categorias">
                        <i class="bi bi-circle"></i><span>Categorias</span>
                        </a>
                    </li>
                    <li>
                        <a href="usuarios">
                        <i class="bi bi-circle"></i><span>Usuários</span>
                        </a>
                    </li>
                    <li>
                        <a href="grupos">
                        <i class="bi bi-circle"></i><span>Grupos</span>
                        </a>
                    </li>
                </ul>
            </li>
        
            <li class="nav-item">
                <a class="nav-link collapsed" href="atendimentos">
                  <i class="bi bi-journal-text"></i>
                  <span>Atendimentos</span>
                </a>
            </li>
      
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-layout-text-window-reverse"></i><span>Relatórios</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="tables-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                  <li>
                      <a href="#" data-bs-toggle="modal" data-bs-target="#myModal-rel-user" >
                        <i class="bi bi-circle"></i><span>Relatório de usuários</span>
                      </a>
                  </li>
                  <li>
                      <a href="#" data-bs-toggle="modal" data-bs-target="#myModal-rel-atendimentos" >
                        <i class="bi bi-circle"></i><span>Relatório de atendimentos</span>
                      </a>
                  </li>
                </ul>
            </li>
       
            <li class="nav-item">
              <a class="nav-link collapsed" href="backups">
                <i class="bi bi-gear"></i>
                <span>Configurações</span>
              </a>
            </li>
            
            <li class="nav-item">
              <a class="nav-link collapsed" href="logs">
                <i class="bi bi-exclamation-circle"></i>
                <span>Logs</span>
              </a>
            </li>
        
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('admin.sair') }}">
                <i class="bi bi-box-arrow-in-left"></i>
                <span>Sair</span>
                </a>
            </li><!-- End Login Page Nav -->
        </ul>

    </aside><!-- End Sidebar-->
    <main id="main" class="main">

    <!-- includes -->

    @include("admin/modal/modal-rel-user")
    @include("admin/modal/modal-rel-atendimentos")

    <!-- Conteudo do Projeto -->

    @yield('conteudo')

    <!-- Fim do Projeto -->

    </main><!-- End #main -->
    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
        <div class="copyright">
            &copy; Copyright <strong><span>{{ config('app.nome') }} - {{ config('app.ano') }}</span></strong>. All Rights Reserved
        </div>
        <div class="credits">
            <!-- All the links in the footer should remain intact. -->
            <!-- You can delete the links only if you purchased the pro version. -->
            <!-- Licensing information: https://bootstrapmade.com/license/ -->
            <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
            Designed by <a href="#">{{ config('app.autor') }}</a>
        </div>
    </footer><!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.js') }}"></script>
    <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>
    <script src="{{ asset('assets/vendor/quill/quill.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>

    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.11.3/datatables.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>

    <script src="{{ asset('assets/vendor/chart.js/chart.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/echarts/echarts.min.js') }}"></script>

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdn.jsdelivr.net/gh/farhadmammadli/bootstrap-select@main/js/bootstrap-select.min.js"></script>  
  
    <!-- Others JS File -->
    <script src="{{ asset('assets/js/util.js?vs=06') }}"></script>
    <script src="{{ asset('assets/js/sweetalert2.all.min.js') }}"></script>
  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>
    <script>
        jQuery(function($){
            $(".telefone").mask("99-999999999");
        });
    </script>

    <!-- Template Main JS File -->
    <script src="{{ asset('assets/js/main.js?vs=02') }}"></script>

    <script>
        $(document).ready(function() {
            $('.datatable').DataTable({
                responsive: true
            });
        });
    </script>
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip(); 
        });
    </script>
    <script>
        /* verifica url para o menu */
        
        jQuery(function ($) {
		
            var pgurl = window.location.href.substr(window.location.href.lastIndexOf("/")+1);
            
            $("ul a").click(function(e) {
                var link = $(this);
                var item = link.parent("li");

                if (link.hasClass("collapsed")) {
                    link.removeClass("collapsed");
                } else {
                    link.addClass("collapsed");
                }

                if (item.children("ul").length > 0) {
                    var href = link.attr("href");
                    link.attr("href", "#");
                    setTimeout(function () { 
                        link.attr("href", href);
                    }, 300);
                    e.preventDefault();
                }
            }).each(function() {
                    var link = $(this);
                    if (link.get(0).href === location.href) {
                        link.removeClass("collapsed");
                        return false;
                    }else if (pgurl === '') {
                    $("aside ul li a").each(function(){
                        if($(this).attr("id") == 'home' )
                        $(this).removeClass("collapsed");
                     })
                }
                });
            });
        </script>
    </body>
</html>