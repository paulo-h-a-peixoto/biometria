@extends('relatorio.index')
@section('title', 'Relatório Ponto Eletrônico')
    
@section('content')
<div class="home_content">
    <div class="logo">
        @if (session('success'))
        @component('components.success')
            {{session('success')}}
        @endcomponent
        @endif
        @if ($errors->any())
        @component('components.danger')
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
        @endcomponent
        @endif
        <b>Emitir Relatório da pessoa</b>
        <img src="{{url('/assets/images/graficanovo.png')}}">
        <form method="POST" style="width:80%;">
            @csrf
            <div class="form-group">
                <input type="text" name="documento" class="form-control" id="exampleInputEmail1"  placeholder="Digite o documento do funcionário">
            </div>
            <div class="form-group row">
                <label for="example-datetime-local-input" class="col-5 col-form-label">Data ínicio</label>
                <div class="col-8">
                  <input class="form-control" type="date" name="dataInicio" value="{{date('Y-m-d')}}" id="example-datetime-local-input">
                </div>
            </div>
            <div class="form-group row">
            <label for="example-datetime-local-input" class="col-5 col-form-label">Data final</label>
            <div class="col-8">
                <input class="form-control" type="date" name="dataFinal" value="{{date('Y-m-d')}}" id="example-datetime-local-input">
            </div>
            </div>
            
            <br>
            <input type="submit" target="_blank" class="btn btn-success btn-lg btn-block" value="Buscar">
            </form>
    </div>
</div>
@endsection