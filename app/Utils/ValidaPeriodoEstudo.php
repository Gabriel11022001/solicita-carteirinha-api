<?php

namespace App\Utils;

class ValidaPeriodoEstudo
{
    
    private static array $periodos = [
        'Diurno',
        'Noturno',
        'Integral',
        'Matutino'
    ];

    public static function validarPeriodo(string $periodo): bool
    {

        if (in_array($periodo, self::$periodos)) {

            return true;
        }

        return false;
    }
}