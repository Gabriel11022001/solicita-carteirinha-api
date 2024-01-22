<?php

namespace App\Utils;

use App\Constantes\NiveisAcesso;

class ValidaNivelAcesso
{

    public static function validarNivelAcesso(string $nivelAcesso) {

        if ($nivelAcesso != NiveisAcesso::ADMIN
        && $nivelAcesso != NiveisAcesso::ESTUDANTE) {

            return false;
        }

        return true;
    }
}