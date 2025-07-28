@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Lista de Procedimentos</h1>
        <a href="{{ route('procedimentos.create') }}" class="btn btn-success">Cadastrar Novo Procedimento</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Valor Padrão</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($procedimentos as $procedimento)
                <tr>
                    <td>{{ $procedimento->id_procedimento }}</td>
                    <td>{{ $procedimento->nome }}</td>
                    <td>R$ {{ number_format($procedimento->valor_padrao, 2, ',', '.') }}</td>
                    <td>
                        <a href="{{ route('procedimentos.edit', $procedimento->id_procedimento) }}" class="btn btn-primary btn-sm">Editar</a>
                        <form action="{{ route('procedimentos.destroy', $procedimento->id_procedimento) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza?')">Excluir</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">Nenhum procedimento encontrado.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection