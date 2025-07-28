@extends('layouts.app')

@section('content')
    <h1>Editar Paciente: {{ $paciente->nome }}</h1>

    <form action="{{ route('pacientes.update', $paciente->id_paciente) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="nome" class="form-label">Nome Completo:</label>
            <input type="text" id="nome" name="nome" class="form-control" value="{{ $paciente->nome }}" required>
        </div>
        <div class="mb-3">
            <label for="cpf" class="form-label">CPF (apenas números):</label>
            <input type="text" id="cpf" name="cpf" class="form-control" value="{{ $paciente->cpf }}" required>
        </div>
        <div class="mb-3">
            <label for="nascimento" class="form-label">Data de Nascimento:</label>
            <input type="date" id="nascimento" name="nascimento" class="form-control" value="{{ $paciente->nascimento }}" required>
        </div>
        <div class="mb-3">
            <label for="telefone" class="form-label">Telefone:</label>
            <input type="text" id="telefone" name="telefone" class="form-control" value="{{ $paciente->telefone }}">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">E-mail:</label>
            <input type="email" id="email" name="email" class="form-control" value="{{ $paciente->email }}">
        </div>
        <div class="mb-3">
            <label for="endereco" class="form-label">Endereço:</label>
            <input type="text" id="endereco" name="endereco" class="form-control" value="{{ $paciente->endereco }}">
        </div>
        <button type="submit" class="btn btn-primary">Atualizar Paciente</button>
        <a href="{{ route('pacientes.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection

@push('scripts')
<script>
    const cpfElement = document.getElementById('cpf');
    const cpfMaskOptions = {
        mask: '000.000.000-00',
        lazy: false
    };
    const cpfMask = IMask(cpfElement, cpfMaskOptions);
    const telefoneElement = document.getElementById('telefone');
    const telefoneMaskOptions = {
        mask: '(00) 00000-0000',
        lazy: false
    };
    const telefoneMask = IMask(telefoneElement, telefoneMaskOptions);
</script>
@endpush