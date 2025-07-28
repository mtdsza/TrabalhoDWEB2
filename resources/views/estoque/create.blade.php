@extends('layouts.app')

@section('content')
    <h1>Adicionar Novo Item ao Estoque</h1>

    <form action="{{ route('estoque.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="descricao" class="form-label">Descrição:</label>
            <input type="text" id="descricao" name="descricao" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="quantidade" class="form-label">Quantidade Inicial:</label>
            <input type="number" step="0.001" id="quantidade" name="quantidade" class="form-control" value="0" required>
        </div>
        <div class="mb-3">
            <label for="estoque_min" class="form-label">Estoque Mínimo:</label>
            <input type="number" step="0.001" id="estoque_min" name="estoque_min" class="form-control" value="0" required>
        </div>
        <button type="submit" class="btn btn-primary">Salvar</button>
        <a href="{{ route('estoque.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection