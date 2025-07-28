<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
use App\Models\Estoque;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $consultasHoje = Consulta::with('paciente', 'profissional')
            ->whereDate('data_inicio', today())
            ->orderBy('data_inicio', 'asc')
            ->get();
        $itensEstoqueBaixo = Estoque::where('quantidade', '<=', DB::raw('estoque_min'))->get();
        return view('dashboard', [
            'consultasHoje' => $consultasHoje,
            'totalConsultasHoje' => $consultasHoje->count(),
            'itensEstoqueBaixo' => $itensEstoqueBaixo
        ]);
    }
}