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
        <b>Cadastro de usuário</b>
        <img src="{{url('/assets/images/graficanovo.png')}}">
        <form method="POST" style="width:80%;">
            @csrf
            <div class="form-group">
                <input type="text" name="nome" value="{{old('nome')}}" class="form-control" id="exampleInputEmail1"  placeholder="Digite o nome do usuário">
            </div>
            <div class="form-group">
                <input type="text" name="login" value="{{old('login')}}" class="form-control" id="exampleInputEmail1"  placeholder="Digite o login do usuário">
            </div>
            <div class="form-group">
                <input type="text" name="divisao" value="{{old('divisao')}}" class="form-control" id="exampleInputEmail1"  placeholder="Digite a divisão/secão">
            </div>
                <div class="form-group">
                <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Digite a senha">
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="1" name="admin" id="defaultCheck1">
                <label class="form-check-label" for="defaultCheck1">
                  Administrador
                </label>
            </div>
            <br>
            <input type="submit" class="btn btn-success btn-lg btn-block" value="Cadastrar">
            </form>
    </div>
</div>
@endsection