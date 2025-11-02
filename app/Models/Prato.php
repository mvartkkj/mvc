<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prato extends Model
{
    protected $table = 'pratos';

    protected $fillable = [
        'nome',
        'descricao',
        'preco',
        'categoria',
        'foto_prato',
        'disponivel',
        'ordem'
    ];

    protected $casts = [
        'preco' => 'decimal:2',
        'disponivel' => 'boolean',
    ];

    // Retorna a URL completa da foto
    public function getFotoUrlAttribute()
    {
        if ($this->foto_prato) {
            return asset('images/pratos/' . $this->foto_prato);
        }
        return asset('images/placeholder.png');
    }

    // Scope para buscar apenas disponíveis
    public function scopeDisponiveis($query)
    {
        return $query->where('disponivel', 1);
    }

    // Scope para ordenar
    public function scopeOrdenados($query)
    {
        return $query->orderBy('ordem', 'asc')->orderBy('nome', 'asc');
    }
}