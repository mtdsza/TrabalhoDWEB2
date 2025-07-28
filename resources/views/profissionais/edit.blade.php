@extends('layouts.app')

@section('content')
    <h1>Editar Profissional: {{ $profissional->nome }}</h1>

    <form action="{{ route('profissionais.update', $profissional->id_profissional) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="nome" class="form-label">Nome Completo:</label>
            <input type="text" id="nome" name="nome" class="form-control" value="{{ $profissional->nome }}" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">E-mail:</label>
            <input type="email" id="email" name="email" class="form-control" value="{{ $profissional->email }}" required>
        </div>
        <div class="mb-3">
            <label for="cro" class="form-label">CRO:</label>
            <input type="text" id="cro" name="cro" class="form-control" value="{{ $profissional->cro }}" required>
        </div>
        <div class="mb-3">
            <label for="telefone" class="form-label">Telefone:</label>
            <input type="text" id="telefone" name="telefone" class="form-control" value="{{ $profissional->telefone }}">
        </div>
        <button type="submit" class="btn btn-primary">Atualizar Profissional</button>
        <a href="{{ route('profissionais.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection