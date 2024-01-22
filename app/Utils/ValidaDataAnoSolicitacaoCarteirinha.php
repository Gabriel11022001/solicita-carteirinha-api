<?php

namespace App\Utils;

use DateTime;

class ValidaDataAnoSolicitacaoCarteirinha
{

    public static function validar(int $ano): bool
    {
        $dataAtual = new DateTime('now');
        $anoAtual = $dataAtual->format('Y');

        if ($anoAtual > $ano) {

            return false;
        }

        return true;
    }
}