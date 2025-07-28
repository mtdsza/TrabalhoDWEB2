<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profissional;

class ProfissionalController extends Controller
{
    public function index()
    {
        $profissionais = Profissional::all();
        return view('profissionais.index', ['profissionais' => $profissionais]);
    }
    public function create()
    {
        return view('profissionais.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:profissionais',
            'cro' => 'required|string|max:15',
            'telefone' => 'nullable|string|max:13',
        ]);
        Profissional::create($request->all());
        return redirect()->route('profissionais.index')
                        ->with('success', 'Profissional cadastrado com sucesso!');
    }
    public function show(string $id)
    {
        //
    }
    public function edit(string $id)
    {
        $profissional = Profissional::findOrFail($id);
        return view('profissionais.edit', ['profissional' => $profissional]);
    }
    public function update(Request $request, string $id)
    {
        $profissional = Profissional::findOrFail($id);

        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:profissionais,email,' . $profissional->id_profissional . ',id_profissional',
            'cro' => 'required|string|max:15',
            'telefone' => 'nullable|string|max:13',
        ]);

        $profissional->update($request->all());

        return redirect()->route('profissionais.index')
                         ->with('success', 'Profissional atualizado com sucesso!');
    }
    public function destroy(string $id)
    {
        $profissional = Profissional::findOrFail($id);
        $profissional->delete();

        return redirect()->route('profissionais.index')
                         ->with('success', 'Profissional excluído com sucesso!');
    }
}
