@extends('relatorio.index')
@section('title', 'Relatório Ponto Eletrônico')
    
@section('content')

<h2>Relatórios</h2>
<div class="table-responsive">
  <table class="table table-striped table-sm">
    <thead>
      <tr>
        <th>#</th>
        <th>Relatório</th>
        <th>Data</th>
        <th>Status</th>
        <th>Opções</th>
      </tr>
    </thead>
    <tbody>
        @foreach ($rel as $item)
        <tr>
            <td>{{$item->id}}</td>
            <td>{{$item->n_relatorio}}</td>
            <td>{{$item->data}}</td>
            <td>{{($item->status == 0) ? 'PENDENTE':'CONCLUIDO'}}</td>
        <td>
            <div class="btn-group" role="group" >
            <a class="btn btn-primary" style="color:#fff;" href="{{url('/relatorio/id/'.$item->id)}}">Visualizar</a>
            @if ($item->status == 0)
            <a class="btn btn-success" style="color:#fff;" href="{{url('/relatorio/fin/'.$item->id)}}">Finalizar</a>
            @endif
            
          </div>
        </td>
        </tr>
        @endforeach
      
    </tbody>
  </table>
</div>
@endsection