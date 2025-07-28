@extends('layouts.app')

@section('content')
    <h1>Cadastrar Nova Especialidade</h1>

    <form action="{{ route('especialidades.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nome" class="form-label">Nome:</label>
            <input type="text" id="nome" name="nome" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Salvar</button>
        <a href="{{ route('especialidades.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection