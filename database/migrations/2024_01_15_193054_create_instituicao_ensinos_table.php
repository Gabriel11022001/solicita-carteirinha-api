<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('instituicao_ensinos', function (Blueprint $table) {
            $table->id();
            $table->string('descricao')
                ->nullable(false)
                ->unique('descricao_instituicao_ensino_unique_id')
                ->max(255);
            $table->boolean('status')
                ->nullable(false)
                ->default(true);
            $table->string('cidade')
                ->nullable(false)
                ->max(255);
        });
    }

    public function down()
    {
        Schema::dropIfExists('instituicao_ensinos');
    }
};
