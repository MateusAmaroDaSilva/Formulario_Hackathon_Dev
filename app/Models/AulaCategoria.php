<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AulaCategoria extends Model
{
    protected $fillable = ['nome', 'slug', 'cor', 'icone'];
    
    /**
     * Uma categoria pode ter várias aulas
     */
    public function aulas()
    {
        return $this->hasMany(Aula::class, 'aula_categoria_id');
    }
}
