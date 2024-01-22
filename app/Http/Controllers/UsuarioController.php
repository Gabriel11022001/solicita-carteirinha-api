<?php

namespace App\Http\Controllers;

use App\Servico\UsuarioServico;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    private UsuarioServico $usuarioServico;

    public function __construct(UsuarioServico $usuarioServico)
    {
        $this->usuarioServico = $usuarioServico;
    }

    public function preCadastro(Request $requisicao): JsonResponse
    {

        return $this->usuarioServico->preCadastro($requisicao);
    }

    public function buscarTodosUsuarios(): JsonResponse
    {

        return $this->usuarioServico->buscarTodosUsuarios();
    }

    public function buscarUsuarioPeloId(int $id): JsonResponse
    {

        return $this->usuarioServico->buscarUsuarioPeloId($id);
    }
}
