<?php

namespace App\Servico;

use App\Models\Usuario;
use App\Utils\Log;
use App\Utils\RespostaHttp;
use App\Utils\ValidaDataNascimento;
use App\Utils\ValidaNivelAcesso;
use App\Utils\ValidaNumeroResidencia;
use App\Utils\ValidaSexo;
use Exception;
use Illuminate\Contracts\Support\MessageBag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UsuarioServico
{

    public function preCadastro(Request $requisicao): JsonResponse
    {

        try {
            $erros = $this->validarCamposPreCadastro($requisicao);

            if (count($erros) > 0) {

                return RespostaHttp::resp('Ocorreram erros de validação de dados!', $erros);
            }

            $errosValidacaoDados = [];

            if (!$this->validarSenhasSaoIguais($requisicao->senha, $requisicao->senha_confirmacao)) {
                $errosValidacaoDados['senha_confirmacao'] = 'A senha e a senha de confirmação devem ser iguais!';
            }

            if (!ValidaNivelAcesso::validarNivelAcesso($requisicao->nivel_acesso_usuario)) {
                $errosValidacaoDados['nivel_acesso_usuario'] = 'Nível de acesso inválido!';
            }

            if (!ValidaSexo::validarSexo($requisicao->sexo)) {
                $errosValidacaoDados['sexo'] = 'Sexo inválido!';
            }

            if (!ValidaNumeroResidencia::validarNumeroResidencia($requisicao->numero_residencia)) {
                $errosValidacaoDados['numero_residencia'] = 'Número de residência inválido!';
            }

            if (!ValidaDataNascimento::validarDataNascimento($requisicao->data_nascimento)) {
                $errosValidacaoDados['data_nascimento'] = 'Data de nascimento inválido!';
            }

            if (count($errosValidacaoDados) > 0) {

                return RespostaHttp::resp('Ocorreram erros de validação de dados!', $errosValidacaoDados);
            }

            if ($this->validarDuplicidadeCpf(
                $requisicao->cpf,
                $requisicao->nivel_acesso_usuario
            )) {

                return RespostaHttp::resp('Informe outro cpf!');
            }

            $usuario = new Usuario();
            $usuario->nome = mb_strtoupper($requisicao->nome);
            $usuario->email = $requisicao->email;
            $usuario->senha = md5($requisicao->senha);
            $usuario->cpf = $requisicao->cpf;
            $usuario->telefone = $requisicao->telefone;
            $usuario->sexo = $requisicao->sexo;
            $usuario->data_nascimento = $requisicao->data_nascimento;
            $usuario->nivel_acesso_usuario = $requisicao->nivel_acesso_usuario;
            $usuario->cep = $requisicao->cep;
            $usuario->endereco = $requisicao->endereco;
            $usuario->bairro = $requisicao->bairro;
            $usuario->cidade = $requisicao->cidade;
            $usuario->uf = $requisicao->uf;
            $usuario->numero_residencia = $requisicao->numero_residencia;

            if ($usuario->save()) {

                return RespostaHttp::resp(
                    'Cadastro realizado com sucesso!',
                    [],
                    $usuario->toArray(),
                    201
                );
            }

            return RespostaHttp::resp(
                'Ocorreu um erro ao tentar-se cadastrar o usuário!'
            );
        } catch (Exception $e) {
            Log::logCadastro(
                'Ocorreu o seguinte erro ao tentar-se cadastrar o usuário: ' . $e->getMessage(),
                $requisicao->all()
            );

            return RespostaHttp::resp('Ocorreu um erro ao tentar-se cadastrar o usuário!' . $e->getMessage());
        }

    }

    private function validarDuplicidadeCpf(string $cpf, string $nivelAcesso): bool
    {
        $usuario = Usuario::where('nivel_acesso_usuario', $nivelAcesso)
            ->where('cpf', $cpf)
            ->get()
            ->first();
        
        var_dump($usuario);

        return $usuario != null;
    }

    private function validarSenhasSaoIguais(string $senha, string $senhaConfirmacao): bool
    {

        if ($senha != $senhaConfirmacao) {

            return false;
        }

        return true;
    }

    private function validarCamposPreCadastro(Request $requisicao): array|MessageBag
    {
        $validador = Validator::make($requisicao->all(),
        [
            'nome' => 'required|max:255',
            'email' => 'required|email|max:255|unique:usuarios',
            'telefone' => 'required|max:255|celular_com_ddd',
            'cpf' => 'required|max:14|min:14|cpf',
            'senha' => 'required|max:128|min:8',
            'senha_confirmacao' => 'required',
            'sexo' => 'required|max:255',
            'cep' => 'required|formato_cep',
            'endereco' => 'required',
            'bairro' => 'required',
            'cidade' => 'required',
            'uf' => 'required|uf',
            'nivel_acesso_usuario' => 'required'
        ],
        [
            'nome.required' => 'Informe seu nome!',
            'nome.max' => 'O nome pode possuir no máximo 255 caracteres!',
            'email.required' => 'Informe seu e-mail!',
            'email.email' => 'E-mail inválido!',
            'email.max' => 'O e-mail pode possuir no máximo 255 caracteres!',
            'email.unique' => 'Informe outro e-mail!',
            'telefone.required' => 'Informe seu telefone celular!',
            'telefone.max' => 'O telefone pode possuir no máximo 255 caracteres!',
            'telefone.celular_com_ddd' => 'O formato do telefone informado é inválido!',
            'cpf.required' => 'Informe seu cpf!',
            'cpf.max' => 'O cpf deve possuir 14 caracteres!',
            'cpf.min' => 'O cpf deve possuir 14 caracteres!',
            'cpf.cpf' => 'Cpf inválido!',
            'senha.required' => 'Informe sua senha!',
            'senha.max' => 'A senha deve possuir no máximo 128 caracteres!',
            'senha.min' => 'A senha deve possuir no mínimo 8 caracteres!',
            'senha_confirmacao.required' => 'Informe sua senha de confirmação!',
            'sexo.required' => 'Informe seu sexo!',
            'sexo.max' => 'O sexo pode possuir no máximo 255 caracteres!',
            'cep.required' => 'Informe o cep!',
            'cep.formato_cep' => 'O formato do cep informado é inválido!',
            'endereco.required' => 'Informe o endereço!',
            'bairro.required' => 'Informe o bairro!',
            'cidade.required' => 'Informe a cidade!',
            'uf.required' => 'Informe a unidade federativa!',
            'nivel_acesso_usuario.required' => 'Informe o nível de acesso!'
        ]);

        if ($validador->fails()) {

            return $validador->errors();
        }

        return [];
    }

    public function buscarTodosUsuarios(): JsonResponse
    {

        try {
            $usuarios = DB::table('usuarios')
                ->select('id', 'nome', 'telefone', 'cpf', 'status')
                ->orderBy('nome')
                ->get()
                ->toArray();

            if (count($usuarios) === 0) {

                return RespostaHttp::respListar('Não existem usuários cadastrados no banco de dados!');
            }

            foreach ($usuarios as $usuario) {
                $usuario->status = $usuario->status === 1 ? 'Ativo' : 'Inativo';
            }

            return RespostaHttp::respListar(
                'Usuários encontrados com sucesso!',
                $usuarios
            );
        } catch (Exception $e) {

            return RespostaHttp::respListar('Ocorreu um erro ao tentar-se listar todos os usuários!');
        }

    }

    public function buscarUsuarioPeloId(int $id): JsonResponse
    {

        try {

            if (empty($id)) {

                return RespostaHttp::respConsultar(
                    'Informe o id do usuário!'
                );
            }

            $usuario = DB::table('usuarios')
                ->select([
                    'id',
                    'nome',
                    'telefone',
                    'email',
                    'data_nascimento',
                    'cpf',
                    'sexo',
                    'nivel_acesso_usuario',
                    'rg',
                    'status',
                    'cep',
                    'endereco',
                    'bairro',
                    'cidade',
                    'uf',
                    'numero_residencia'
                ])
                ->where('id', $id)
                ->get()
                ->toArray();

            if (!$usuario) {

                return RespostaHttp::respConsultar('Não existe um usuário cadastrado com esse id!');
            }

            $usuario[0]->status = $usuario[0]->status === 1 ? 'Ativo' : 'Inativo';

            return RespostaHttp::respConsultar(
                'Usuário encontrado com sucesso!',
                $usuario
            );
        } catch (Exception $e) {

            return RespostaHttp::respConsultar('Ocorreu um erro ao tentar-se buscar o usuário pelo id!');
        }

    }
}