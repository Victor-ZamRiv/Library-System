<?php
namespace App\Models\Services;

class FechaService
{
    /**
     * Suma días hábiles (lunes a viernes) a una fecha.
     * @param string $fechaInicio Formato 'Y-m-d'
     * @param int $diasSumar
     * @return string
     * @throws \Exception
     */
    public function sumarDiasHabiles(string $fechaInicio, int $diasSumar): string
    {
        $fecha = new \DateTime($fechaInicio);
        $contados = 0;
        while ($contados < $diasSumar) {
            $fecha->modify('+1 day');
            $diaSemana = (int) $fecha->format('N');
            if ($diaSemana < 6) { // lunes a viernes
                $contados++;
            }
        }
        return $fecha->format('Y-m-d');
    }
}