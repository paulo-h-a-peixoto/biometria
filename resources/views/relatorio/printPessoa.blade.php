<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="{{url('assets/css/style.css')}}" rel="stylesheet" media="print" />
    
</head>
<body>
    <div class="print_content">
        <div class="table-responsive">
            <table class="table table-striped table-sm">
              <thead>
                <tr>
                  <th>Nome</th>
                  <th>Divisão/Seção</th>
                  <th>Entrada</th>
                  <th>Saída</th>
                  <th>Data</th>
                  <th>Justificativa</th>
                </tr>
              </thead>
              <tbody>
                  @foreach ($result as $item)
                    @if ($dataInicio <= date_format(date_create(str_replace("/", "-", $item->data)), 'Y-m-d') && ($dataFinal >= date_format(date_create(str_replace("/", "-", $item->data)), 'Y-m-d')))
                    
                    <tr>
                      <td>{{$item->nome}}</td>
                      <td>{{$item->divisao}}</td>
                      <td>{{$item->hora_entrada}}</td>
                      <td>{{$item->hora_saida}}</td>
                      <td>{{$item->data}}</td>
                      <td>{{$item->justify}}</td>
                    </tr>
                    @endif
                  @endforeach
                  
                
              </tbody>
              
            </table>
            
          </div>
    </div>

    <script type="text/javascript">
        window.addEventListener("load", window.print());
    </script>
</body>
</html>