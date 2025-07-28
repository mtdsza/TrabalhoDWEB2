@extends('layouts.app')

@section('content')
    <h1>Cadastrar Novo Profissional</h1>

    <form action="{{ route('profissionais.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nome" class="form-label">Nome Completo:</label>
            <input type="text" id="nome" name="nome" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">E-mail:</label>
            <input type="email" id="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="cro" class="form-label">CRO:</label>
            <input type="text" id="cro" name="cro" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="telefone" class="form-label">Telefone:</label>
            <input type="text" id="telefone" name="telefone" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Salvar Profissional</button>
        <a href="{{ route('profissionais.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection