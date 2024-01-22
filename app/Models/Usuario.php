<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'id',
        'nome',
        'email',
        'telefone',
        'senha',
        'sexo',
        'cpf',
        'rg',
        'data_nascimento',
        'nivel_acesso_usuario',
        'cep',
        'endereco',
        'bairro',
        'cidade',
        'uf',
        'numero_residencia',
        'documento_identidade_foto_frente',
        'documento_identidade_foto_verso',
        'comprovante_residencia'
    ];
}
