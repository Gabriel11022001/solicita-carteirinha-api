<?php

namespace App\Utils;

use DateTime;

class ValidaDataNascimento
{

    public static function validarDataNascimento(string $dataNascimento): bool
    {
        $dataAtual = new DateTime('now');
        $dataNascimentoObj = new DateTime($dataNascimento);

        if ($dataAtual < $dataNascimento) {

            return false;
        }

        return true;
    }
}