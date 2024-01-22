<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('nome')
                ->nullable(false)
                ->max(255);
            $table->string('telefone')
                ->nullable(false)
                ->max(255);
            $table->string('email')
                ->nullable(false)
                ->unique('email_usuario_unique_id')
                ->max(255);
            $table->string('senha')
                ->nullable(false)
                ->max(128)
                ->min(8);
            $table->string('nivel_acesso_usuario')
                ->nullable(false);
            $table->date('data_nascimento')
                ->nullable(true);
            $table->string('sexo')
                ->nullable(false)
                ->max(255);
            $table->string('cpf')
                ->nullable(false)
                ->max(14)
                ->min(14);
            $table->string('rg')
                ->nullable(true);
            $table->string('cep')
                ->nullable(false);
            $table->text('endereco')
                ->nullable(false);
            $table->text('bairro')
                ->nullable(false);
            $table->string('cidade')
                ->nullable(false);
            $table->string('uf')
                ->nullable(false)
                ->max(2)
                ->min(2);
            $table->string('numero_residencia')
                ->nullable(false)
                ->default('s/n');
            $table->text('documento_identidade_foto_frente')
                ->nullable(true);
            $table->text('documento_identidade_foto_verso')
                ->nullable(true);
            $table->text('comprovante_residencia')
                ->nullable(true);
            $table->boolean('status')
                ->nullable(false)
                ->default(true);
        });
    }

    public function down()
    {
        Schema::dropIfExists('usuarios');
    }
};
