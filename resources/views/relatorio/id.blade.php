@extends('relatorio.index')

@section('title', 'Relatório')
    
@section('content')
<div class="content-menu">
  <a class="btn btn-success btn-small" style="color:#fff;" href="{{url('/relatorio/print/'.$id)}}">Imprimir</a>
</div>
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
        <th>Documento</th>
        <th>Nome</th>
        <th>Divisão/Seção</th>
        <th>Hora_entrada</th>
        <th>Hora_saida</th>
        <th>Data</th>
        <th>Justificativa</th>
        <th>Opções</th>
      </tr>
    </thead>
    <tbody>
        @foreach ($result as $item)
        <tr>
            <td>{{$item->documento}}</td>
            <td>{{$item->nome}}</td>
            <td>{{$item->divisao}}</td>
            <td>{{$item->hora_entrada}}</td>
            <td>{{$item->hora_saida}}</td>
            <td>{{$item->data}}</td>
            <td>{{$item->justify}}</td>
            <td>
              <button type="button" class="btn btn-success justificar" data-toggle="modal" value="{{$item->id}}" data-target="#exampleModalCenter" >
                Justificar
              </button>
            </td>
           
        </tr>
        @endforeach
      
    </tbody>
  </table>
</div>
<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Justificativa</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="/relatorio/justify">
      @csrf
      <input type="hidden" name="id" value="" id="id">
      
      <input type="hidden" name="rel" value="{{$id}}">
      <div class="modal-body">
        <div class="form-group">
            <label for="exampleFormControlSelect1">Opções</label>
            <select name="opcoes" class="form-control" id="opcoes">
              <option>Selecionar</option>
              <option value="Férias">Férias</option>
              <option value="Dispensa">Dispensa</option>
              <option value="Atestado médico">Atestado médico</option>
              <option value="Serviço">Serviço</option>
              <option value="5">Outros</option>
            </select>
          </div>
          <div class="form-group row  date">
            <label for="example-datetime-local-input" class="col-5 col-form-label">Data ínicio</label>
            <div class="col-8">
              <input class="form-control" type="date" name="dataInicio" value="{{date('Y-m-d')}}" id="example-datetime-local-input">
            </div>
          </div>
          <div class="form-group row  date">
            <label for="example-datetime-local-input" class="col-5 col-form-label">Data final</label>
            <div class="col-8">
              <input class="form-control" type="date" name="dataFinal" value="{{date('Y-m-d')}}" id="example-datetime-local-input">
            </div>
          </div>
          <div class="form-group justify">
            <label for="exampleFormControlTextarea1">Digite a justificativa</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" name="justificativa" rows="3"></textarea>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        <input type="submit" value="Salvar" class="btn btn-primary" />
      </div>
    </form>
    </div>
  </div>
</div>
@endsection