@extends('relatorio.index')
@section('title', 'Relatório Ponto Eletrônico')
    
@section('content')
    <div class="home_content">
        <div class="container">
            <h3>Atualização dos integrantes</h3>
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

            <img src="{{url('/assets/images/graficanovo.png')}}" style="width:90px; height:133px;">
            <form method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                <label for="exampleFormControlFile1">Insira o arquivo contendo os nomes</label>
                <input type="file" class="form-control-file" name="names">
                </div>
                <input type="submit" class="btn btn-success btn-lg btn-block" value="Carregar">
            </form>
        </div>
    </div>
@endsection