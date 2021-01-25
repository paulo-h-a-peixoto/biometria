<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://getbootstrap.com/docs/4.0/examples/dashboard/dashboard.css" rel="stylesheet">
    <link href="{{url('assets/css/style.css')}}" rel="stylesheet">
    <title>@yield('title')</title>
    
</head>
<body>
    <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0">
      <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="{{url('/relatorio/home')}}">Relatório Ponto Eletrônico</a>
      
      <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
          <a class="nav-link" href="{{url('/logout')}}">Sair</a>
        </li>
      </ul>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
          <div class="sidebar-sticky">
            <ul class="nav flex-column">
              <li class="nav-item">
                <a class="nav-link active" href="{{url('/relatorio/home')}}">
                  <span data-feather="home"></span>
                  Dashboard <span class="sr-only">(current)</span>
                </a>
              </li>
              @if ($admin)
              <li class="nav-item">
                <a class="nav-link" aria-current="page" href="{{url('/relatorio')}}">
                  <span data-feather="users"></span>
                  Relatórios
                </a>
              </li>
              @endif
              <li class="nav-item">
                <a class="nav-link" aria-current="page" href="{{url('/relatorio/jrelatorio')}}">
                  <span data-feather="users"></span>
                  Justificar relatório
                </a>
              </li>
              
            </ul>
            @if ($admin)
            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                <span>Relatório</span>
               
            </h6>
            <ul class="nav flex-column mb-2">
                <li class="nav-item">
                    <a class="nav-link" href="{{url('/relatorio/gerar')}}">
                      <span data-feather="file-text"></span>
                      Gerar Relatório geral
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{url('/relatorio/pessoa')}}">
                      <span data-feather="file-text"></span>
                      Gerar relatório da pessoa
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{url('/relatorio/update')}}">
                    <span data-feather="file-text"></span>
                    Atualizar Integrantes
                  </a>
                </li>
            </ul>
            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
              <span>Administração</span>
              
            </h6>
            <ul class="nav flex-column mb-2">
              
              <li class="nav-item">
                <a class="nav-link" href="{{url('/relatorio/usuarios')}}">
                  <span data-feather="file-text"></span>
                  Usuários
                </a>
              </li>
              
            </ul>
            @endif
          </div>
        </nav>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
        @yield('content')
        </main>
      </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    
    <script src="{{url('assets/js/jquery-slim.min.js')}}"></script>
    
    
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="{{url('assets/js/script.js')}}"></script>

    <!-- Icons -->
    <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
    <script>
      feather.replace()
    </script>
    
  </body>