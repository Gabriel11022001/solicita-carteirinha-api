<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('solicitacaos', function (Blueprint $table) {
            $table->id();
            $table->dateTime('data_solicitacao')
                ->nullable(false);
            $table->text('foto_estudante')
                ->nullable(false);
            $table->text('assinatura');
            $table->unsignedBigInteger('instituicao_id')
                ->nullable(false);
            $table->string('curso')
                ->nullable(false)
                ->max(255);
            $table->string('periodo')
                ->nullable(false)
                ->max(255);
            $table->string('termo')
                ->nullable(false)
                ->max(255);
            $table->integer('ano')
                ->nullable(false);
            $table->string('status')
                ->nullable(false)
                ->max(255)
                ->default('Aguardando análise');
            $table->unsignedBigInteger('usuario_id')
                ->nullable(false);
            $table->foreign('usuario_id')
                ->references('id')
                ->on('usuarios');
            $table->foreign('instituicao_id')
                ->references('id')
                ->on('instituicao_ensinos');
        });
    }

    public function down()
    {
        Schema::dropIfExists('solicitacaos');
    }
};
