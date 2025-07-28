@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Gerenciador de Usuários</h1>
        <a href="{{ route('usuarios.create') }}" class="btn btn-success">Criar Novo Usuário</a>
    </div>
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Login</th>
                <th>Email</th>
                <th>Tipo</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($usuarios as $usuario)
                <tr>
                    <td>{{ $usuario->id }}</td>
                    <td>{{ $usuario->login }}</td>
                    <td>{{ $usuario->email }}</td>
                    <td>{{ $usuario->tipo }}</td>
                    <td>
                        <a href="{{ route('usuarios.edit', $usuario->id) }}" class="btn btn-primary btn-sm">Editar</a>
                        
                        {{-- Impede que o botão de excluir apareça para o próprio usuário logado --}}
                        @if(auth()->user()->id !== $usuario->id)
                        <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza?')">Excluir</button>
                        </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Nenhum usuário encontrado.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection