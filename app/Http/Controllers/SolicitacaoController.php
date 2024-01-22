<?php

namespace App\Http\Controllers;

use App\Servico\SolicitacaoServico;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SolicitacaoController extends Controller
{
    private SolicitacaoServico $solicitacaoServico;

    public function __construct(SolicitacaoServico $solicitacaoServico)
    {
        $this->solicitacaoServico = $solicitacaoServico;
    }

    public function realizarSolicitacao(Request $requisicao): JsonResponse
    {

        return $this->solicitacaoServico->realizarSolicitacao($requisicao);
    }
}
