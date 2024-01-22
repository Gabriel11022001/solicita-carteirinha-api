<?php

namespace App\Servico;

use App\Models\InstituicaoEnsino;
use App\Utils\RespostaHttp;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class InstituicaoEnsinoServico
{

    public function cadastrarInstituicaoEnsino(Request $requisicao): JsonResponse
    {
        
        try {
            $validador = Validator::make($requisicao->all(),
            [
                'descricao' => 'required|max:255|unique:instituicao_ensinos',
                'cidade' => 'required|max:255'
            ],
            [
                'descricao.required' => 'Informe a descrição da instituição!',
                'descricao.max' => 'A descrição da instituição não deve possuir mais que 255 caracteres!',
                'descricao.unique' => 'Já existe uma outra instituição cadastrada com essa descrição!',
                'cidade.required' => 'Informe a cidade da instituição de ensino!',
                'cidade.max' => 'A cidade não deve possuir mais que 255 caracteres!'
            ]);

            if ($validador->fails()) {

                return RespostaHttp::resp(
                    'Ocorreu um erro ao tentar-se cadastrar a instituição de ensino!',
                    $validador->errors()->toArray()
                );
            }

            $instituicaoEnsino = new InstituicaoEnsino();
            $instituicaoEnsino->descricao = $requisicao->descricao;
            $instituicaoEnsino->cidade = $requisicao->cidade;

            if (!$instituicaoEnsino->save()) {

                return RespostaHttp::resp(
                    'Ocorreu um erro ao tentar-se cadastrar a instituição de ensino!',
                    $requisicao->all()
                );
            }

            return RespostaHttp::resp(
                'Instituição de ensino cadastrada com sucesso!',
                [],
                $instituicaoEnsino->toArray(),
                201
            );
        } catch (Exception $e) {

            return RespostaHttp::resp(
                'Ocorreu um erro ao tentar-se cadastrar a instituição no banco de dados!',
                $requisicao->all()
            );
        }

    }

    public function buscarTodasInstituicoes(): JsonResponse
    {

        try {
            $instituicoes = DB::table('instituicao_ensinos')
                ->orderBy('descricao', 'ASC')
                ->get()
                ->toArray();

            if (count($instituicoes) === 0) {

                return RespostaHttp::respListar(
                    'Não existem instituições cadastradas no banco de dados!'
                );
            }

            return RespostaHttp::respListar(
                'Instituições encontradas com sucesso!',
                $instituicoes
            );
        } catch (Exception $e) {

            return RespostaHttp::respListar(
                'Ocorreu um erro ao tentar-se buscar todas as instituições!'
            );
        }

    }

    public function buscarInstituicaoPeloId(int $id): JsonResponse
    {

        try {

            if (empty($id)) {

                return RespostaHttp::respConsultar(
                    'Informe o id da instituição!'
                );
            }

            $instituicao = InstituicaoEnsino::find($id);

            if (!$instituicao) {

                return RespostaHttp::respConsultar(
                    'Não existe uma instituição cadastrada no banco de dados com esse id!'
                );
            }

            return RespostaHttp::respConsultar(
                'Instituição encontrada com sucesso!',
                $instituicao->toArray()
            );
        } catch (Exception $e) {

            return RespostaHttp::respConsultar(
                'Ocorreu um erro ao tentar-se buscar a instituição pelo id!'
            );
        }

    }

}