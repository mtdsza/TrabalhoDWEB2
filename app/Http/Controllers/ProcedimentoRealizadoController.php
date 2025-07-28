<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
use App\Models\ProcedimentoRealizado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProcedimentoRealizadoController extends Controller
{
    public function store(Request $request, Consulta $consulta)
    {
        $request->validate([
            'id_procedimento' => 'required|exists:procedimentos,id_procedimento',
            'valor_cobrado' => 'required|numeric|min:0',
            'descricao' => 'nullable|string',
        ]);

        ProcedimentoRealizado::create([
            'id_consulta' => $consulta->id_consulta,
            'id_procedimento' => $request->id_procedimento,
            'valor_cobrado' => $request->valor_cobrado,
            'descricao' => $request->descricao,
        ]);

        return redirect()->route('consultas.show', $consulta->id_consulta)
                         ->with('success', 'Procedimento registrado com sucesso!');
    }

    public function anexar(Request $request, ProcedimentoRealizado $procedimentoRealizado)
    {
        $request->validate([
            'anexo' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);
        if ($procedimentoRealizado->anexo) {
            Storage::disk('public')->delete($procedimentoRealizado->anexo);
        }
        $path = $request->file('anexo')->store('anexos', 'public');
        $procedimentoRealizado->anexo = $path;
        $procedimentoRealizado->save();

        return redirect()->route('consultas.show', $procedimentoRealizado->id_consulta)
                         ->with('success', 'Anexo enviado com sucesso!');
    }
}