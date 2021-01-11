@extends('relatorio.index')
@section('title', 'Relatório Ponto Eletrônico')
    
@section('content')

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
                      <option value="0">Entrada ou Dia</option>
                      <option value="1">Saida ( Alterando a hora saida )</option>
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
    </div>
</div>

@endsection
