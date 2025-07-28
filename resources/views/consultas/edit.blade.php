@extends('layouts.app')

@section('content')
    <h1>Editar Consulta</h1>

    <form action="{{ route('consultas.update', $consulta->id_consulta) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="id_paciente" class="form-label">Paciente:</label>
            <select id="id_paciente" name="id_paciente" class="form-select" required>
                @foreach ($pacientes as $paciente)
                    <option value="{{ $paciente->id_paciente }}" @if($paciente->id_paciente == $consulta->id_paciente) selected @endif>
                        {{ $paciente->nome }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="id_profissional" class="form-label">Profissional:</label>
            <select id="id_profissional" name="id_profissional" class="form-select" required>
                @foreach ($profissionais as $profissional)
                    <option value="{{ $profissional->id_profissional }}" @if($profissional->id_profissional == $consulta->id_profissional) selected @endif>
                        {{ $profissional->nome }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="data_inicio" class="form-label">Data e Hora da Consulta:</label>
            <input type="datetime-local" id="data_inicio" name="data_inicio" class="form-control" value="{{ $consulta->data_inicio }}" required>
        </div>
        <div class="mb-3">
            <label for="descricao" class="form-label">Descrição/Motivo:</label>
            <textarea id="descricao" name="descricao" class="form-control" rows="4">{{ $consulta->descricao }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Atualizar Consulta</button>
        <a href="{{ route('consultas.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection