@extends('layouts.app')

@section('content')
    <h1>Editar Usuário: {{ $usuario->login }}</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ route('usuarios.update', $usuario->id) }}" method="POST" novalidate>
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="login" class="form-label">Login:</label>
            <input type="text" id="login" name="login" class="form-control" value="{{ old('login', $usuario->login) }}" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">E-mail:</label>
            <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $usuario->email) }}" required>
        </div>

        <div class="mb-3">
            <label for="tipo" class="form-label">Tipo de Usuário:</label>
            <select name="tipo" id="tipo" class="form-select" required>
                <option value="Secretaria" @if(old('tipo', $usuario->tipo) == 'Secretaria') selected @endif>Secretaria</option>
                <option value="Profissional" @if(old('tipo', $usuario->tipo) == 'Profissional') selected @endif>Profissional</option>
                <option value="Admin" @if(old('tipo', $usuario->tipo) == 'Admin') selected @endif>Admin</option>
            </select>
        </div>

        <hr>
        <p class="text-muted">Deixe os campos de senha em branco para não alterá-la.</p>

        <div class="mb-3">
            <label for="password" class="form-label">Nova Senha:</label>
            <input type="password" id="password" name="password" class="form-control">
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirmar Nova Senha:</label>
            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Atualizar Usuário</button>
        <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection