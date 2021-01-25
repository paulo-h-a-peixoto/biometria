<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://getbootstrap.com/docs/4.0/examples/dashboard/dashboard.css" rel="stylesheet">
    <link href="{{url('assets/css/style.css')}}" rel="stylesheet">
</head>
<body>
    <div class="table-responsive">
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th>#</th>
              <th>Data</th>
              <th>Status</th>
              <th>Opções</th>
            </tr>
          </thead>
          <tbody>
              @foreach ($rel as $item)
              <tr>
                  <td>{{$item->id}}</td>
                  <td>{{$item->data}}</td>
                  <td>{{($item->status == 0) ? 'PENDENTE':'CONCLUIDO'}}</td>
              <td>
                  <div class="btn-group" role="group" >
                  <a class="btn btn-primary" style="color:#fff;"  target="_blank"  href="{{url('/relatorio/print/'.$item->id)}}">Visualizar</a>         
                </div>
              </td>
              </tr>
              @endforeach
            
          </tbody>
        </table>
      </div>
</body>
</html>