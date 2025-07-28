@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Especialidades</h1>
        <a href="{{ route('especialidades.create') }}" class="btn btn-success">Cadastrar Nova</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($especialidades as $especialidade)
            <tr>
                <td>{{ $especialidade->id_especialidade }}</td>
                <td>{{ $especialidade->nome }}</td>
                <td>
                    <a href="{{ route('especialidades.edit', $especialidade->id_especialidade) }}" class="btn btn-primary btn-sm">Editar</a>
                    <form action="{{ route('especialidades.destroy', $especialidade->id_especialidade) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza?')">Excluir</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3" class="text-center">Nenhuma especialidade encontrada.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
@endsection