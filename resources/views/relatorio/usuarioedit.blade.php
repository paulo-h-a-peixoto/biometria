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
        <b>Editar usuário</b>
        <img src="{{url('/assets/images/graficanovo.png')}}">
        <form method="POST" style="width:80%;">
            @csrf
            <div class="form-group">
                <input type="text" name="nome" value="{{$usuario->name}}" class="form-control" id="exampleInputEmail1"  placeholder="Digite o nome do usuário">
            </div>
            <div class="form-group">
                <input type="text" readonly value="{{$usuario->usuario}}" class="form-control" id="exampleInputEmail1"  placeholder="Digite o login do usuário">
            </div>
            <div class="form-group">
                <input type="text" name="divisao" value="{{$usuario->divisao}}" class="form-control" id="exampleInputEmail1"  placeholder="Digite a divisão/secão">
            </div>
                <div class="form-group">
                <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Digite a nova senha">
            </div>
            <div class="form-check">
                <input {{($usuario->admin == '1')?'checked':''}} class="form-check-input" type="checkbox" value="1" name="admin" id="defaultCheck1">
                <label  class="form-check-label" for="defaultCheck1">
                  Administrador
                </label>
            </div>
            <br>
            <input type="submit" class="btn btn-success btn-lg btn-block" value="Editar">
            </form>
    </div>
</div>
@endsection