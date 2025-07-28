<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\Consulta;

class HorarioDisponivel implements ValidationRule
{
    protected $profissionalId;
    protected $dataInicio;
    protected $consultaId;
    public function __construct($profissionalId, $dataInicio, $consultaId = null)
    {
        $this->profissionalId = $profissionalId;
        $this->dataInicio = new \DateTime($dataInicio);
        $this->consultaId = $consultaId;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $dataFim = (clone $this->dataInicio)->modify('+1 hour');
        $query = Consulta::where('id_profissional', $this->profissionalId)
            ->where('situacao', '!=', 'Cancelada')
            ->where(function ($q) use ($dataFim) {
                $q->where('data_inicio', '<', $dataFim)
                  ->whereRaw('? < DATE_ADD(data_inicio, INTERVAL 1 HOUR)', [$this->dataInicio->format('Y-m-d H:i:s')]);
            });

        if ($this->consultaId) {
            $query->where('id_consulta', '!=', $this->consultaId);
        }

        if ($query->exists()) {
            $fail('O profissional já possui uma consulta agendada neste horário.');
        }
    }
}