@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Orçamentos</h1>
        <a href="{{ route('orcamentos.create') }}" class="btn btn-success">Criar Novo Orçamento</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Paciente</th>
                <th>Data de Emissão</th>
                <th>Valor Total</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($orcamentos as $orcamento)
            <tr>
                <td>{{ $orcamento->id_orcamento }}</td>
                <td>{{ $orcamento->paciente->nome }}</td>
                <td>{{ \Carbon\Carbon::parse($orcamento->data_emissao)->format('d/m/Y') }}</td>
                <td>R$ {{ number_format($orcamento->valor_total, 2, ',', '.') }}</td>
                <td>
                    <a href="{{ route('orcamentos.show', $orcamento->id_orcamento) }}" class="btn btn-info btn-sm">Ver Detalhes</a>
                    <a href="{{ route('orcamentos.edit', $orcamento->id_orcamento) }}" class="btn btn-primary btn-sm">Editar</a>
                    <form action="{{ route('orcamentos.destroy', $orcamento->id_orcamento) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza?')">Excluir</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">Nenhum orçamento encontrado.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
@endsection