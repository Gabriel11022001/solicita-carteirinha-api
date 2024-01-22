<?php

namespace App\Utils;

use Illuminate\Http\JsonResponse;

class RespostaHttp
{

    public static function resp(string $mensagem, array $errosCampos = [], array $entidade = [], int $codigoHttp = 200): JsonResponse
    {

        return response()
            ->json([
                'msg' => $mensagem,
                'erros_campos' => $errosCampos,
                'entidade' => $entidade
            ], $codigoHttp);
    }

    public static function respListar(string $mensagem, array $entidades = [], int $codigoHttp = 200) {

        return response()
            ->json([
                'msg' => $mensagem,
                'entidades' => $entidades
            ], $codigoHttp);
    }

    public static function respConsultar(
        string $mensagem,
        array $entidade = null,
        int $codigoHttp = 200
    ): JsonResponse
    {
        
        return response()
            ->json([
                'msg' => $mensagem,
                'entidade' => $entidade
            ], $codigoHttp);
    }
}