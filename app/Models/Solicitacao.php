<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Solicitacao extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'id',
        'data_solicitacao',
        'foto_estudante',
        'assinatura',
        'curso',
        'ano',
        'periodo',
        'termo',
        'status',
        'instituicao_id',
        'usuario_id'
    ];

    public function usuario(): HasOne
    {

        return $this->hasOne(Usuario::class);
    }

    public function instituicao(): HasOne
    {

        return $this->hasOne(InstituicaoEnsino::class);
    }
}
