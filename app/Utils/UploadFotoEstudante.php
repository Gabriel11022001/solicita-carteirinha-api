<?php

namespace App\Utils;

use Illuminate\Http\Request;

class UploadFotoEstudante implements UploadArquivo
{

    public function upload(Request $requisicao): string
    {
        $diretorio = 'fotos_estudantes';
        $foto = $requisicao->foto_estudante;
        
        return $foto->store($diretorio);
    }
}