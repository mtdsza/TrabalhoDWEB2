@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Lista de Pacientes</h1>
        @can('manage-patients')
            <a href="{{ route('pacientes.create') }}" class="btn btn-success">Cadastrar Novo Paciente</a>
        @endcan
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>CPF</th>
                <th>Nascimento</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pacientes as $paciente)
                <tr>
                    <td>{{ $paciente->id_paciente }}</td>
                    <td>{{ $paciente->nome }}</td>
                    <td>{{ $paciente->cpf }}</td>
                    <td>{{ \Carbon\Carbon::parse($paciente->nascimento)->format('d/m/Y') }}</td>
                    <td>
                        <a href="{{ route('pacientes.show', $paciente->id_paciente) }}" class="btn btn-info btn-sm">Ver</a>
                        <a href="{{ route('pacientes.edit', $paciente->id_paciente) }}" class="btn btn-primary btn-sm">Editar</a>
                        <form action="{{ route('pacientes.destroy', $paciente->id_paciente) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza?')">Excluir</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Nenhum paciente encontrado.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection