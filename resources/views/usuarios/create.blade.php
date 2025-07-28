@extends('layouts.app')

@section('content')
    <h1>Criar Novo Usuário</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('usuarios.store') }}" method="POST" novalidate>
        @csrf
        <div class="mb-3">
            <label for="login" class="form-label">Login:</label>
            <input type="text" id="login" name="login" class="form-control" value="{{ old('login') }}" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">E-mail:</label>
            <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required>
        </div>

        <div class="mb-3">
            <label for="tipo" class="form-label">Tipo de Usuário:</label>
            <select name="tipo" id="tipo" class="form-select" required>
                <option value="Secretaria" @if(old('tipo') == 'Secretaria') selected @endif>Secretaria</option>
                <option value="Profissional" @if(old('tipo') == 'Profissional') selected @endif>Profissional</option>
                <option value="Admin" @if(old('tipo') == 'Admin') selected @endif>Admin</option>
            </select>
        </div>

        <div class="mb-3" id="campo_profissional" style="display: none;">
            <label for="id_profissional" class="form-label">Vincular ao Profissional:</label>
            <select name="id_profissional" id="id_profissional" class="form-select">
                <option value="">Selecione um profissional</option>
                @foreach($profissionais as $profissional)
                    <option value="{{ $profissional->id_profissional }}">{{ $profissional->nome }} (CRO: {{ $profissional->cro }})</option>
                @endforeach
            </select>
            <small class="form-text text-muted">Este campo é obrigatório se o tipo for "Profissional".</small>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Senha:</label>
            <input type="password" id="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirmar Senha:</label>
            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Salvar Usuário</button>
        <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
    <script>
        document.getElementById('tipo').addEventListener('change', function () {
            var campoProfissional = document.getElementById('campo_profissional');
            if (this.value === 'Profissional') {
                campoProfissional.style.display = 'block';
                document.getElementById('id_profissional').setAttribute('required', 'required');
            } else {
                campoProfissional.style.display = 'none';
                document.getElementById('id_profissional').removeAttribute('required');
            }
        });
        document.getElementById('tipo').dispatchEvent(new Event('change'));
    </script>
@endsection