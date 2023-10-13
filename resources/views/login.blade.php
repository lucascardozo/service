<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1.0" name="viewport">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
      
        <title>{{ $title }}</title>
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

        <!-- Template Main CSS File -->
        <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

        <!-- =======================================================
        * Template Name: NiceAdmin - v2.1.0
        * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
        * Author: BootstrapMade.com
        * License: https://bootstrapmade.com/license/
        ======================================================== -->
        <script src='https://www.google.com/recaptcha/api.js'></script>
    </head>
    <body>
        <main>
            <div class="container">
                <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                  <div class="container">
                    <div class="row justify-content-center">
                      <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                        <!-- DIV DE ALERTA -->
                        <div>
                          @if($error == 1)
                            <div class="alert alert-danger">
                                <h4>Atenção!</h4>
                                <label>
                                    <span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> Usuário ou senha incorretos, favor entrar em contato com o responsável pelo sistema!
                                </label>
                            </div>
                          @endif
                          @if($error == 2)
                            <div class="alert alert-danger">
                                <h4>Atenção!</h4>
                                <label>
                                    <span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> Necessário realizar o login para ter acesso ao sistema!
                                </label>
                            </div>
                          @endif
                        </div>
                        <!-- FIM DE ALERTA -->

                        <div class="d-flex justify-content-center py-4"></div><!-- End Logo -->
                        <div class="card mb-3">
                          <div class="card-body">
                            <div class="text-center pt-4 pb-2">
                                <a href="#" class="rounded mx-auto d-block">
                                    <img style="max-height: 150px;" src="{{ asset('assets/img/logo.png?vs=02') }}" alt="">
                                    <span class="d-none d-lg-block"></span>
                                </a>
                                <h5 class="card-title text-center pb-0 fs-4">Login para sua conta</h5>
                                <p class="text-center small">Entre com seu usuário e senha</p>
                            </div>

                            <form class="row g-3 needs-validation" method="post" action="{{ route('login') }}" >
                                @csrf
                                <div class="col-12">
                                    <label for="yourUsername" class="form-label">Login</label>
                                    <div class="input-group has-validation">
                                      <input type="text" name="login" class="form-control" id="yourUsername" value="{{ old('login') }}" placeholder="Usuário" >
                                    </div>
                                     {{ $errors->has("login") ? $errors->first("login") : '' }}
                                </div>

                                <div class="col-12">
                                    <label for="yourPassword" class="form-label">Password</label>
                                    <input type="password" name="senha" class="form-control" id="yourPassword" value="{{ old('senha') }}" placeholder="Senha">
                                     {{ $errors->has("senha") ? $errors->first("senha") : '' }}
                                </div>

                                <div class="col-12">
                                    <button class="btn btn-primary w-100" id="cmdContinuar" type="submit">Entrar</button>
                                </div>
                            </form>
                          </div>
                        </div>

                        <div class="credits">
                          Designed by <a href="#">{{ config('app.autor') }}</a>
                        </div>

                      </div>
                    </div>
                  </div>
                </section>
            </div>
        </main><!-- End #main -->

        <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

        <!-- Vendor JS Files -->
        <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.js') }}"></script>
        <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>
        <script src="{{ asset('assets/vendor/quill/quill.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
        <script src="{{ asset('assets/vendor/chart.js/chart.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/echarts/echarts.min.js') }}"></script>
		
		<script>
            function enableBtn(){
                document.getElementById("cmdContinuar").disabled = false;
            }			
		</script>

        <!-- Template Main JS File -->
        <script src="{{ asset('assets/js/main.js') }}"></script>
    </body>
</html>