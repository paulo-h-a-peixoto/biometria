@extends('relatorio.index')
@section('title', 'Relatório Ponto Eletrônico')
    
@section('content')

<h2>Usuários</h2>
<div class="table-responsive">
  <table class="table table-striped table-sm">
    <thead>
      <tr>
        <th>#</th>
        <th>Nome</th>
        <th>Login</th>
        <th>Divisão</th>
        <th>Opções</th>
      </tr>
    </thead>
    <tbody>
        @foreach ($usuarios as $item)
        <tr>
            <td>{{$item->id}}</td>
            <td>{{$item->name}}</td>
            <td>{{$item->usuario}}</td>
            <td>{{$item->divisao}}</td>
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