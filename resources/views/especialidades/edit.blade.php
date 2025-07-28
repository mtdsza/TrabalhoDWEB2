@extends('layouts.app')

@section('content')
    <h1>Editar Especialidade</h1>

    <form action="{{ route('especialidades.update', $especialidade->id_especialidade) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="nome" class="form-label">Nome:</label>
            <input type="text" id="nome" name="nome" class="form-control" value="{{ $especialidade->nome }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Atualizar</button>
        <a href="{{ route('especialidades.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection