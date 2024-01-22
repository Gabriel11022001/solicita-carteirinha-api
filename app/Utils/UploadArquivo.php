<?php

namespace App\Utils;

use Illuminate\Http\Request;

interface UploadArquivo
{
    function upload(Request $requisicao): string;
}