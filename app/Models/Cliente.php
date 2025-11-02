<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clientes';
    protected $primaryKey = 'cod_cliente'; // Sua chave primária
    public $timestamps = false; // Se sua tabela NÃO tem created_at/updated_at
    
    protected $fillable = [
        'nome',
        'cpf',
        'rg',
        'data_nasc',
        'endereco',
        'numero',
        'bairro',
        'cod_cidade',
        'cep',
        'celular',
        'e_mail',
        'cargo_id',
        'passwd',
    ];

    protected $hidden = [
        'passwd', // Ocultar senha em JSON
    ];

    // Relacionamento com Cargo
    public function cargo()
    {
        return $this->belongsTo(Cargo::class, 'cargo_id');
    }

    // Criptografar senha automaticamente ao salvar
    public function setPasswdAttribute($value)
    {
        $this->attributes['passwd'] = Hash::make($value);
    }
}