@extends('relatorio.index')
@section('title', 'Relatório Ponto Eletrônico')
    
@section('content')
<div class="content-menu">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalLong">
        Ficou com dúvida ?
    </button>
</div>

<div class="home_content">
    <div class="container">
        
        @if ($errors->any())
        @foreach ($errors->all() as $error)
            @component('components.danger')
            {{$error}}
            @endcomponent
        @endforeach            
        @endif
        @if (session('error'))
            @component('components.danger')
                {{session('error')}}
            @endcomponent
        @endif
        @if (session('warning'))
            @component('components.success')
                {{session('warning')}}
            @endcomponent
        @endif
        <h3>Importação dos dados</h3>
            <img src="{{url('/assets/images/graficanovo.png')}}" style="width:90px; height:133px;">
            <form method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="exampleFormControlFile1">Insira o arquivo contendo os acessos</label>
                    <input type="file" name="acesso" class="form-control-file">
                </div>
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Tipo de relatório</label>
                    <select class="form-control" name="tipo" id="exampleFormControlSelect1">
                      <option value="0">Entrada</option>
                      <option value="1">Saída</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Horário de Tolerância</label>
                    <select class="form-control" name="tolerancia" id="exampleFormControlSelect1">
                      <option value="9:00">9:00</option>
                      <option value="8:00">8:00</option>
                    </select>
                  </div>
                <input type="submit" class="btn btn-success btn-lg btn-block" value="Carregar">
            </form>
            
              


              
              <!-- Modal -->
              <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLongTitle">Manual do relatório - gerar</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                        <div class="campos">
                            <p><b>No arquivo </b>- Os registro dos funcionarios precisa ser no máximo de 24hr exemplo: <br> 00:00 01/01/2021 à 23:59 01/01/2021</p>
                        </div>
                        <div class="campos">
                            <p><b>Tipo de relatório - Entrada</b> - Você pode gerar o relatório no inicio do expediente no caso 00:00 01/01/2021 à 10:00 01/01/2021 ou do dia todo.</p>
                        </div>
                        <div class="campos">
                            <p><b>Tipo de relatório - Saída</b> - Esse relatório só será utilizado para complementar o relatório do início de expediente inserindo o horário de saída. </p>
                        </div>
                        <div class="campos">
                            <p><b>Horário de Tolerância</b> - Esse dado será utilizado para definir o horario de tolerância para o ínicio de expediente </p>
                        </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    </div>
                  </div>
                </div>
              </div>
    </div>
</div>

@endsection
