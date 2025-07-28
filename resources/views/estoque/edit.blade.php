@extends('layouts.app')

@section('content')
    <h1>Editar Item do Estoque</h1>

    <form action="{{ route('estoque.update', $item->id_item_estoque) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="descricao" class="form-label">Descrição:</label>
            <input type="text" id="descricao" name="descricao" class="form-control" value="{{ $item->descricao }}" required>
        </div>
        <div class="mb-3">
            <label for="quantidade" class="form-label">Quantidade Atual:</label>
            <input type="number" step="0.001" id="quantidade" name="quantidade" class="form-control" value="{{ $item->quantidade }}" required>
        </div>
        <div class="mb-3">
            <label for="estoque_min" class="form-label">Estoque Mínimo:</label>
            <input type="number" step="0.001" id="estoque_min" name="estoque_min" class="form-control" value="{{ $item->estoque_min }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Atualizar</button>
        <a href="{{ route('estoque.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection