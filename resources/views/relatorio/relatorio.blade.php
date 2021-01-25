@extends('relatorio.index')
@section('title', 'Relatório Ponto Eletrônico')
    
@section('content')
@if (session('alert'))
@component('components.success')
    {{session('alert')}}
@endcomponent
@endif
<h2>Relatórios</h2>
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
            <a class="btn btn-primary" style="color:#fff;" href="{{url('/relatorio/id/'.$item->id)}}">Visualizar</a>
            @if ($item->status == 0)
            <a class="btn btn-success" style="color:#fff;" href="{{url('/relatorio/fin/'.$item->id)}}">Finalizar</a>
            @else
            <a class="btn btn-success" style="color:#fff;" href="{{url('/relatorio/vol/'.$item->id)}}">Voltar</a>
            @endif
            <a class="btn btn-danger" style="color:#fff;" href="{{url('/relatorio/delRel/'.$item->id)}}">Excluir</a>
            
          </div>
        </td>
        </tr>
        @endforeach
      
    </tbody>
  </table>
</div>
@endsection