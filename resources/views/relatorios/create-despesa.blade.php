@extends('layouts.app')
@section('content')
    <h1>Lançar Nova Despesa</h1>
    <form action="{{ route('financeiro.storeDespesa') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="descricao" class="form-label">Descrição:</label>
            <input type="text" id="descricao" name="descricao" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="valor" class="form-label">Valor (R$):</label>
            <input type="number" step="0.01" id="valor" name="valor" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="data_movimentacao" class="form-label">Data:</label>
            <input type="date" id="data_movimentacao" name="data_movimentacao" class="form-control" value="{{ now()->toDateString() }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Salvar Despesa</button>
        <a href="{{ route('relatorios.financeiro') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection