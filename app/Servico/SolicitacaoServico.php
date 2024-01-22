<?php

namespace App\Servico;

use App\Utils\Log;
use App\Utils\RespostaHttp;
use App\Utils\UploadFotoEstudante;
use App\Utils\ValidaDataAnoSolicitacaoCarteirinha;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SolicitacaoServico
{

    private UploadFotoEstudante $uploadFotoEstudante;

    public function __construct(UploadFotoEstudante $uploadFotoEstudante)
    {
        $this->uploadFotoEstudante = $uploadFotoEstudante;
    }

    public function realizarSolicitacao(Request $requisicao): JsonResponse
    {

        try {
            $errosCampos = $this->validarDadosCadastroSolicitacao($requisicao);

            if (count($errosCampos) > 0) {

                return RespostaHttp::resp(
                    'Ocorreram erros de validação de dados!',
                    $errosCampos
                );
            }

            if (!ValidaDataAnoSolicitacaoCarteirinha::validar($requisicao->ano)) {

                return RespostaHttp::resp('Você não pode solicitar uma carteirinha para um ano que já passou!');
            }

        } catch (Exception $e) {
            Log::logCadastro(
                'Ocorreu o seguinte erro ao tentar-se cadastrar a solicitação de carteirinha: ' . $e->getMessage(),
                $requisicao->all()
            );

            return RespostaHttp::resp(
                'Ocorreu um erro ao tentar-se cadastrar a solicitação!'
            );
        }

    }

    private function validarDadosCadastroSolicitacao(Request $requisicao): array
    {
        $errosCampos = [];
        $validador = Validator::make($requisicao->all(),
        [
            'foto_estudante' => 'required|image',
            'curso' => 'required|max:255',
            'ano' => 'required|numeric',
            'periodo' => 'required|max:255',
            'termo' => 'required|max:255',
            'usuario_id' => 'required|numeric|min:1',
            'instituicao_id' => 'required|numeric|min:1'
        ],
        [
            'foto_estudante.required' => 'Informe sua foto!',
            'foto_estudante.image' => 'Formato do documento inválido!',
            'curso.required' => 'Informe o curso!',
            'curso.max' => 'A descrição do curso não deve possuir mais que 255 caracteres!',
            'ano.required' => 'Informe o ano!',
            'ano.numeric' => 'O ano deve ser um valor numérico!',
            'periodo.required' => 'Informe o período do curso!',
            'periodo.max' => 'A descrição do período não deve ultrapassar 255 caracteres!',
            'termo.required' => 'Informe o termo!',
            'termo.max' => 'A descrição do termo não deve ultrapassar 255 caracteres!',
            'usuario_id.required' => 'Informe o id do usuário!',
            'usuario_id.numeric' => 'O id do usuário deve ser um dado numérico!',
            'usuario_id.min' => 'O id do usuário não deve ser um valor menor que 1!',
            ''
        ]);

        if ($validador->fails()) {
            $errosCampos = $validador->errors()->toArray();
        }

        return $errosCampos;
    }
}