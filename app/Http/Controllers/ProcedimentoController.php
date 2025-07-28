<?php

namespace App\Http\Controllers;

use App\Models\Procedimento;
use Illuminate\Http\Request;

class ProcedimentoController extends Controller
{
    public function index()
    {
        $procedimentos = Procedimento::all();
        return view('procedimentos.index', ['procedimentos' => $procedimentos]);
    }

    public function create()
    {
        return view('procedimentos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'valor_padrao' => 'required|numeric|min:0',
        ]);

        Procedimento::create($request->all());

        return redirect()->route('procedimentos.index')
                         ->with('success', 'Procedimento cadastrado com sucesso!');
    }

    public function edit(string $id)
    {
        $procedimento = Procedimento::findOrFail($id);
        return view('procedimentos.edit', ['procedimento' => $procedimento]);
    }

    public function update(Request $request, string $id)
    {
        $procedimento = Procedimento::findOrFail($id);

        $request->validate([
            'nome' => 'required|string|max:255',
            'valor_padrao' => 'required|numeric|min:0',
        ]);

        $procedimento->update($request->all());

        return redirect()->route('procedimentos.index')
                         ->with('success', 'Procedimento atualizado com sucesso!');
    }

    public function destroy(string $id)
    {
        $procedimento = Procedimento::findOrFail($id);
        $procedimento->delete();

        return redirect()->route('procedimentos.index')
                         ->with('success', 'Procedimento excluído com sucesso!');
    }
}