@extends('relatorio.index')

@section('title', 'Relatório')
    
@section('content')
<h2>Relatório {{$id}}</h2>
@if (session('alert'))
@component('components.success')
    {{session('alert')}}
@endcomponent
@endif
<div class="table-responsive">
  <table class="table table-striped table-sm">
    <thead>
      <tr>
        <th>#</th>
        <th>Documento</th>
        <th>Nome</th>
        <th>Divisão/Seção</th>
        <th>Hora_entrada</th>
        <th>Hora_saida</th>
        <th>Data</th>
        <th>Justificativa</th>
      </tr>
    </thead>
    <tbody>
        @foreach ($result as $item)
        <tr>
            <td>{{$item->id}}</td>
            <td>{{$item->documento}}</td>
            <td>{{$item->nome}}</td>
            <td>{{$item->divisao}}</td>
            <td>{{$item->hora_entrada}}</td>
            <td>{{$item->hora_saida}}</td>
            <td>{{$item->data}}</td>
            <td>
                <form method="POST">
                  @csrf
                <input type="text" value="{{$item->justify}}" name="justify">
                <input type="hidden" name="id" value="{{$item->id}}">
                <input type="submit" class="btn btn-success btn-small" value="Salvar">
                </form>
            </td>
           
        </tr>
        @endforeach
      
    </tbody>
  </table>
</div>
@endsection