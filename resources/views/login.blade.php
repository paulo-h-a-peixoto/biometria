<!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/docs/4.0/assets/img/favicons/favicon.ico">

    <title>Login sistema biometria</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/sign-in/">

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    

    <!-- Custom styles for this template -->
    <link href="https://getbootstrap.com/docs/4.0/examples/sign-in/signin.css" rel="stylesheet">
  </head>
  
  <body class="text-center">
    
    <form class="form-signin" method="POST">
        @csrf
        @if (session('error'))
        @component('components.danger')
            {{session('error')}}
        @endcomponent
        @endif
        <img src="{{url('/assets/images/graficanovo.png')}}" style="width:90px; height:133px; margin-bottom:20px;">
        <label for="inputEmail" class="sr-only">Usuário</label>
        <input type="text" name="usuario" class="form-control" placeholder="Digite seu usuário" required autofocus>
        <label for="inputPassword" class="sr-only">Senha</label>
        <input type="password" name="password" class="form-control" placeholder="Digite a sua senha" required>
        
      <button class="btn btn-lg btn-primary btn-block" type="submit">Logar</button>
      <p class="mt-5 mb-3 text-muted">&copy; 2021-{{date('Y')}}</p>
    </form>
  </body>
</html>
