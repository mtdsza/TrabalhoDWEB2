@extends('layouts.app')

@section('content')
    <h1>Cadastrar Novo Procedimento</h1>

    <form action="{{ route('procedimentos.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nome" class="form-label">Nome do Procedimento:</label>
            <input type="text" id="nome" name="nome" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="valor_padrao" class="form-label">Valor Padrão (R$):</label>
            <input type="number" step="0.01" id="valor_padrao" name="valor_padrao" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Salvar</button>
        <a href="{{ route('procedimentos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection