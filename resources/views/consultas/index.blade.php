@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Agenda de Consultas</h1>
        <a href="{{ route('consultas.create') }}" class="btn btn-success">Agendar Nova Consulta</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>Data/Hora</th>
                <th>Paciente</th>
                <th>Profissional</th>
                <th>Situação</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($consultas as $consulta)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($consulta->data_inicio)->format('d/m/Y H:i') }}</td>
                    <td>{{ $consulta->paciente->nome }}</td>
                    <td>{{ $consulta->profissional->nome }}</td>
                    <td><span class="badge bg-secondary">{{ $consulta->situacao }}</span></td>
                    <td>
                        <a href="{{ route('consultas.show', $consulta->id_consulta) }}" class="btn btn-info btn-sm">Atendimento</a>
                        <a href="{{ route('consultas.edit', $consulta->id_consulta) }}" class="btn btn-primary btn-sm">Editar</a>
                        @if ($consulta->situacao == 'Agendada')
                            <form action="{{ route('consultas.destroy', $consulta->id_consulta) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-warning btn-sm" onclick="return confirm('Tem certeza que deseja cancelar?')">Cancelar</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Nenhuma consulta agendada.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection