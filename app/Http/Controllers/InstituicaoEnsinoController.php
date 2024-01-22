<?php

namespace App\Http\Controllers;

use App\Servico\InstituicaoEnsinoServico;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InstituicaoEnsinoController extends Controller
{
    private InstituicaoEnsinoServico $instituicaoEnsinoServico;

    public function __construct(InstituicaoEnsinoServico $instituicaoEnsinoServico)
    {
        $this->instituicaoEnsinoServico = $instituicaoEnsinoServico;   
    }

    public function cadastrarInstituicaoEnsino(Request $requisicao): JsonResponse 
    {

        return $this->instituicaoEnsinoServico->cadastrarInstituicaoEnsino($requisicao);
    }

    public function buscarTodasInstituicoes(): JsonResponse
    {

        return $this->instituicaoEnsinoServico->buscarTodasInstituicoes();
    }

    public function buscarInstituicaoPeloId(int $id): JsonResponse
    {

        return $this->instituicaoEnsinoServico->buscarInstituicaoPeloId($id);
    }
}
