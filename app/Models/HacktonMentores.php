<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HacktonMentores extends Model
{
    protected $table = 'hackathonMentores';

    protected $fillable = [
        'nome',
        'rg',
        'instituicao',
        'especialidade',
        'disponibilidade'
    ];

    protected $casts = [
        'disponibilidade' => 'array',
    ];
}
