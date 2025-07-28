@extends('layouts.app')

@section('content')
    <h1>Novo Orçamento</h1>

    <form action="{{ route('orcamentos.store') }}" method="POST">
        @csrf
        <div class="card mb-4">
            <div class="card-header">Dados Gerais</div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="id_paciente" class="form-label">Paciente:</label>
                    <select id="id_paciente" name="id_paciente" class="form-select" required>
                        @foreach ($pacientes as $paciente)
                            <option value="{{ $paciente->id_paciente }}">{{ $paciente->nome }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="id_profissional" class="form-label">Profissional:</label>
                    <select id="id_profissional" name="id_profissional" class="form-select" required>
                        @foreach ($profissionais as $profissional)
                            <option value="{{ $profissional->id_profissional }}">{{ $profissional->nome }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">Procedimentos</div>
            <div class="card-body">
                <div class="input-group mb-3">
                    <select id="procedimento-select" class="form-select">
                        <option value="">Selecione para adicionar</option>
                        @foreach ($procedimentos as $procedimento)
                            <option value="{{ $procedimento->id_procedimento }}" data-nome="{{ $procedimento->nome }}" data-valor="{{ $procedimento->valor_padrao }}">{{ $procedimento->nome }} (R$ {{ number_format($procedimento->valor_padrao, 2, ',', '.') }})</option>
                        @endforeach
                    </select>
                    <button type="button" id="add-procedimento" class="btn btn-outline-secondary">Adicionar</button>
                </div>
                <table class="table">
                    <thead>
                        <tr><th>Procedimento</th><th>Valor Unitário</th><th>Ação</th></tr>
                    </thead>
                    <tbody id="procedimentos-list"></tbody>
                </table>
            </div>
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-primary">Salvar Orçamento</button>
            <a href="{{ route('orcamentos.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>

    <script>
        document.getElementById('add-procedimento').addEventListener('click', function() {
            const select = document.getElementById('procedimento-select');
            const selectedOption = select.options[select.selectedIndex];
            if (!selectedOption.value) return;

            const id = selectedOption.value;
            const nome = selectedOption.getAttribute('data-nome');
            const valor = parseFloat(selectedOption.getAttribute('data-valor')).toFixed(2);

            if (document.querySelector(`input[name="procedimentos[${id}][id_procedimento]"]`)) {
                alert('Este procedimento já foi adicionado.');
                return;
            }

            const list = document.getElementById('procedimentos-list');
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td>${nome}<input type="hidden" name="procedimentos[${id}][id_procedimento]" value="${id}"></td>
                <td><input type="number" step="0.01" name="procedimentos[${id}][valor_unitario]" value="${valor}" class="form-control" required></td>
                <td><button type="button" class="btn btn-danger btn-sm" onclick="this.parentElement.parentElement.remove()">Remover</button></td>
            `;
            list.appendChild(newRow);
        });
    </script>
@endsection