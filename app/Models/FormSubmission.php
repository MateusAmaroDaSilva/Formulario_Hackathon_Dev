<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormSubmission extends Model
{
    protected $fillable = [
        'nome', 
        'email', 
        'telefone', 
        'nascimento', 
        'sexo', 
        'estado', 
        'cidade', 
        'curso', 
        'linkedin', 
        'sobre', 

        'selected_area', 
        'user_answers',

        'score_total', 
        'score_facil', 
        'score_media', 
        'score_dificil', 
        'calculated_level'
    ];

    // usado pra converter o array de respostas para um json
    protected $casts = [
        'user_answers' => 'array',
        'nascimento' => 'date',
    ];
}
