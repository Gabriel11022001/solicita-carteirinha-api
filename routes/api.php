<?php

use App\Http\Controllers\InstituicaoEnsinoController;
use App\Http\Controllers\SolicitacaoController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

Route::prefix('usuario')->group(function () {
    Route::post('/pre-cadastro', [ UsuarioController::class, 'preCadastro' ]);
    Route::get('/', [ UsuarioController::class, 'buscarTodosUsuarios' ]);
    Route::get('/{id}', [ UsuarioController::class, 'buscarUsuarioPeloId' ]);
});

Route::prefix('instituicao')->group(function () {
    Route::post('/', [ InstituicaoEnsinoController::class, 'cadastrarInstituicaoEnsino' ]);
    Route::get('/', [ InstituicaoEnsinoController::class, 'buscarTodasInstituicoes' ]);
    Route::get('/{idInstituicao}', [ InstituicaoEnsinoController::class, 'buscarInstituicaoPeloId' ]);
});

Route::prefix('solicitacao')->group(function () {
    Route::post('/', [ SolicitacaoController::class, 'realizarSolicitacao' ]);
});