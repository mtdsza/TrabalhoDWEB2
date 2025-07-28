@extends('layouts.app')

@section('content')
    <h1>Cadastrar Novo Paciente</h1>

    {{-- Opcional: Mostra um sumário de todos os erros no topo da página --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Ops!</strong> Houve alguns problemas com os dados informados.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('pacientes.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nome" class="form-label">Nome Completo:</label>
            {{-- old('nome') recupera o valor antigo do campo 'nome' --}}
            <input type="text" id="nome" name="nome" class="form-control @error('nome') is-invalid @enderror" value="{{ old('nome') }}" required>
            {{-- @error('nome') exibe a mensagem de erro se a validação para 'nome' falhar --}}
            @error('nome')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="cpf" class="form-label">CPF (apenas números):</label>
            <input type="text" id="cpf" name="cpf" class="form-control @error('cpf') is-invalid @enderror" value="{{ old('cpf') }}" required>
            @error('cpf')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="nascimento" class="form-label">Data de Nascimento:</label>
            <input type="date" id="nascimento" name="nascimento" class="form-control @error('nascimento') is-invalid @enderror" value="{{ old('nascimento') }}" required>
            @error('nascimento')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="telefone" class="form-label">Telefone:</label>
            <input type="text" id="telefone" name="telefone" class="form-control" value="{{ old('telefone') }}">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">E-mail:</label>
            <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}">
        </div>
        <div class="mb-3">
            <label for="endereco" class="form-label">Endereço:</label>
            <input type="text" id="endereco" name="endereco" class="form-control" value="{{ old('endereco') }}">
        </div>
        <button type="submit" class="btn btn-primary">Salvar Paciente</button>
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