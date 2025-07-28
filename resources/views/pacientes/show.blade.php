@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Prontuário do Paciente</h1>
        <a href="{{ route('pacientes.index') }}" class="btn btn-secondary">Voltar para a lista</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card mb-4">
        <div class="card-header fs-5">
            Dados do Paciente
        </div>
        <div class="card-body">
            <p><strong>Nome:</strong> {{ $paciente->nome }}</p>
            <p><strong>CPF:</strong> {{ $paciente->cpf }}</p>
            <p><strong>Data de Nascimento:</strong> {{ \Carbon\Carbon::parse($paciente->nascimento)->format('d/m/Y') }}</p>
            <p><strong>Contato:</strong> {{ $paciente->telefone }} | {{ $paciente->email }}</p>
        </div>
    </div>
    @can('is-professional')
        <div class="card mb-4">
            <div class="card-header fs-5">
                Histórico Geral
            </div>
            <div class="card-body">
                <form action="{{ route('pacientes.salvarHistorico', $paciente->id_paciente) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="historico_odontologico" class="form-label">Histórico Odontológico Pregresso:</label>
                        <textarea name="historico_odontologico" id="historico_odontologico" class="form-control" rows="3">{{ $prontuarioGeral->historico_odontologico ?? '' }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="tratamentos_anteriores" class="form-label">Tratamentos Anteriores:</label>
                        <textarea name="tratamentos_anteriores" id="tratamentos_anteriores" class="form-control" rows="3">{{ $prontuarioGeral->tratamentos_anteriores ?? '' }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Salvar Histórico</button>
                </form>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header fs-5">
            Registros de Atendimento
        </div>
        <ul class="list-group list-group-flush">
            @forelse ($paciente->prontuarios->whereNotNull('id_consulta') as $prontuario)
                <li class="list-group-item">
                    <h5 class="mb-1">
                        <a href="{{ route('consultas.show', $prontuario->id_consulta) }}">
                            Atendimento em {{ \Carbon\Carbon::parse($prontuario->data_registro)->format('d/m/Y') }}
                        </a>
                    </h5>
                    <p class="mb-1"><strong>Diagnóstico:</strong> {{ $prontuario->diagnostico ?? 'Nenhum diagnóstico registrado.' }}</p>
                    <small><strong>Observações:</strong> {{ $prontuario->observacoes ?? 'Nenhuma observação.' }}</small>
                </li>
            @empty
                <li class="list-group-item text-center text-muted">Nenhum registro de atendimento encontrado.</li>
            @endforelse
        </ul>
    </div>
@endsection