<?php

namespace App\Utils;

use App\Constantes\Sexos;

class ValidaSexo
{

    public static function validarSexo($sexo) {

        if ($sexo != Sexos::MASCULINO && $sexo != Sexos::FEMININO) {

            return false;
        }

        return true;
    }
}