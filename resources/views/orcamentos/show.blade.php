@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Detalhes do Orçamento #{{ $orcamento->id_orcamento }}</h1>
        <a href="{{ route('orcamentos.index') }}" class="btn btn-secondary">Voltar para a lista</a>
    </div>

    <div class="card mb-4">
        <div class="card-header">Dados Gerais</div>
        <div class="card-body">
            <p><strong>Paciente:</strong> {{ $orcamento->paciente->nome }}</p>
            <p><strong>Profissional:</strong> {{ $orcamento->profissional->nome }}</p>
            <p><strong>Data de Emissão:</strong> {{ \Carbon\Carbon::parse($orcamento->data_emissao)->format('d/m/Y') }}</p>
            <p><strong>Valor Total:</strong> R$ {{ number_format($orcamento->valor_total, 2, ',', '.') }}</p>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">Itens do Orçamento</div>
        <div class="card-body">
            <table class="table">
                <thead><tr><th>Procedimento</th><th>Valor</th></tr></thead>
                <tbody>
                    @foreach($orcamento->itens as $item)
                    <tr>
                        <td>{{ $item->procedimento->nome }}</td>
                        <td>R$ {{ number_format($item->valor_unitario, 2, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">Controle de Pagamentos</div>
        <div class="card-body">
            <form action="{{ route('orcamentos.gerarParcelas', $orcamento->id_orcamento) }}" method="POST" class="mb-4">
                @csrf
                <div class="input-group">
                    <span class="input-group-text">Gerar parcelamento em:</span>
                    <input type="number" name="numero_parcelas" class="form-control" value="1" min="1">
                    <button type="submit" class="btn btn-outline-primary">Gerar Parcelas</button>
                </div>
            </form>
            <table class="table">
                <thead><tr><th>Nº</th><th>Vencimento</th><th>Valor</th><th>Status</th><th>Ações</th></tr></thead>
                <tbody>
                    @forelse($orcamento->parcelas as $index => $parcela)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ \Carbon\Carbon::parse($parcela->data_vencimento)->format('d/m/Y') }}</td>
                        <td>R$ {{ number_format($parcela->valor, 2, ',', '.') }}</td>
                        <td><span class="badge bg-{{ $parcela->status == 'Paga' ? 'success' : 'warning' }}">{{ $parcela->status }}</span></td>
                        <td>
                            @if($parcela->status == 'Pendente')
                            <form action="{{ route('parcelas.pagar', $parcela->id_parcela) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">Marcar como Paga</button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center">Nenhuma parcela gerada.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection