<?php

namespace App\Utils;

class ValidaNumeroResidencia
{

    public static function validarNumeroResidencia($numeroResidencia) {

        if (is_numeric($numeroResidencia)) {

            if ($numeroResidencia < 1) {

                return false;
            }

        } else {

            if ($numeroResidencia != 's/n') {

                return false;
            }

        }

        return true;
    }
}