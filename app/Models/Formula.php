<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formula extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'descricao', 'cliente_id'];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function ativos()
    {
        return $this->belongsToMany(Ativo::class, 'formula_ativo')
                    ->withTimestamps();
    }
}
