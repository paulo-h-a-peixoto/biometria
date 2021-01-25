@extends('relatorio.index')
@section('title', 'Relatório Ponto Eletrônico')
    
@section('content')

<h2>Justificar relatórios</h2>
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
            <td>{{($item->status == 0) ? 'Aguardando justificativas dos Chefes de Div/seção':'Tempo de Justificar Encerrado'}}</td>
        <td>
            <div class="btn-group" role="group" >
            <a class="btn btn-primary" style="color:#fff;" href="{{url('/relatorio/jid/'.$item->id)}}">Visualizar</a>         
          </div>
        </td>
        </tr>
        @endforeach
      
    </tbody>
  </table>
</div>
@endsection