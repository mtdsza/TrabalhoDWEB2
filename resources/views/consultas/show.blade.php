@extends('layouts.app')

@section('content')
    <h1 class="mb-4">Atendimento da Consulta #{{ $consulta->id_consulta }}</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card mb-4">
        <div class="card-header">
            <h3>Dados da Consulta</h3>
        </div>
        <div class="card-body">
            <p><strong>Paciente:</strong> {{ $consulta->paciente->nome }}</p>
            <p><strong>Profissional:</strong> {{ $consulta->profissional->nome }}</p>
            <p><strong>Data:</strong> {{ \Carbon\Carbon::parse($consulta->data_inicio)->format('d/m/Y H:i') }}</p>
            <p><strong>Situação:</strong> <span class="badge bg-info">{{ $consulta->situacao }}</span></p>
            @if ($consulta->situacao == 'Agendada')
                <hr>
                <form action="{{ route('consultas.finalizar', $consulta->id_consulta) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success">Finalizar Atendimento (Marcar como Realizada)</button>
                </form>
            @endif
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h3>Prontuário Clínico</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('consultas.salvarProntuario', $consulta->id_consulta) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="diagnostico" class="form-label">Diagnóstico:</label>
                    <textarea name="diagnostico" id="diagnostico" class="form-control" rows="3">{{ $consulta->prontuario->diagnostico ?? '' }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="prescricoes" class="form-label">Prescrições:</label>
                    <textarea name="prescricoes" id="prescricoes" class="form-control" rows="3">{{ $consulta->prontuario->prescricoes ?? '' }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="observacoes" class="form-label">Observações:</label>
                    <textarea name="observacoes" id="observacoes" class="form-control" rows="5">{{ $consulta->prontuario->observacoes ?? '' }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary">Salvar Prontuário</button>
            </form>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h3>Procedimentos Realizados</h3>
        </div>
        <div class="card-body">
            <h5 class="mb-3">Procedimentos Registrados</h5>
            <ul class="list-group mb-4">
                @forelse ($consulta->procedimentosRealizados as $proc)
                    <li class="list-group-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <strong>{{ $proc->procedimento->nome }}</strong><br>
                                <small class="text-muted">{{ $proc->descricao }}</small>
                            </div>
                            <div>
                                @if ($proc->anexo)
                                    <a href="{{ Storage::url($proc->anexo) }}" target="_blank" class="btn btn-info btn-sm">Ver Anexo</a>
                                @else
                                    <span class="text-muted">Nenhum anexo</span>
                                @endif
                            </div>
                        </div>
                        <div class="mt-2">
                            <form action="{{ route('procedimentos-realizados.anexar', $proc->id_procedimento_realizado) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="input-group">
                                    <input type="file" name="anexo" class="form-control" required>
                                    <button class="btn btn-outline-secondary btn-sm" type="submit">Enviar</button>
                                </div>
                            </form>
                        </div>
                    </li>
                @empty
                    <li class="list-group-item text-center text-muted">Nenhum procedimento registrado para esta consulta.</li>
                @endforelse
            </ul>

            <hr>
            
            <h5 class="mb-3">Registrar Novo Procedimento</h5>
            <form action="{{ route('procedimentos-realizados.store', $consulta->id_consulta) }}" method="POST">
                @csrf
                {{-- Vamos precisar da lista de todos os procedimentos aqui --}}
                <div class="mb-3">
                    <label for="id_procedimento" class="form-label">Procedimento</label>
                    <select name="id_procedimento" id="id_procedimento" class="form-select">
                        @foreach (\App\Models\Procedimento::all() as $procedimento)
                            <option value="{{ $procedimento->id_procedimento }}" data-valor="{{ $procedimento->valor_padrao }}">{{ $procedimento->nome }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="valor_cobrado" class="form-label">Valor Cobrado (R$)</label>
                    <input type="number" step="0.01" name="valor_cobrado" id="valor_cobrado" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="descricao" class="form-label">Descrição Adicional</label>
                    <textarea name="descricao" id="descricao" rows="2" class="form-control"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Registrar Procedimento</button>
            </form>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h3>Uso de Materiais</h3>
        </div>
        <div class="card-body">
            {{-- Tabela para listar os materiais já adicionados --}}
            <h5 class="mb-3">Materiais Utilizados</h5>
            <table class="table table-sm table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Material</th>
                        <th>Quantidade</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($consulta->usoMateriais as $uso)
                        <tr>
                            {{-- Acessamos a descrição do item através do relacionamento aninhado --}}
                            <td>{{ $uso->itemEstoque->descricao }}</td>
                            <td>{{ $uso->quantidade }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-center text-muted">Nenhum material adicionado a esta consulta.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <hr class="my-4">

            {{-- Formulário para adicionar novos materiais --}}
            <h5 class="mb-3">Adicionar Novo Material</h5>
            <form action="{{ route('consultas.adicionarMaterial', $consulta->id_consulta) }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-8">
                        <label for="id_item_estoque" class="form-label">Material:</label>
                        <select name="id_item_estoque" id="id_item_estoque" class="form-select">
                            @foreach($itensEstoque as $item)
                                <option value="{{ $item->id_item_estoque }}">{{ $item->descricao }} (Atual: {{ $item->quantidade }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="quantidade" class="form-label">Quantidade Utilizada:</label>
                        <input type="number" step="0.001" name="quantidade" id="quantidade" class="form-control" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-success mt-3">Adicionar Material</button>
            </form>
        </div>
    </div>

    <a href="{{ route('consultas.index') }}" class="btn btn-secondary">Voltar para a Agenda</a>
@endsection