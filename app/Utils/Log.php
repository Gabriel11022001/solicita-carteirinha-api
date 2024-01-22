<?php

namespace App\Utils;

use Illuminate\Support\Facades\Log as FacadesLog;

class Log
{

    public static function logCadastro(string $mensagem, array $dados): void
    {
        FacadesLog::error($mensagem, $dados);
    }
}