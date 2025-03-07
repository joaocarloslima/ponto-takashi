<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Funcionario extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'email',
        'telefone',
        'password',
        'matricula',
        'foto'
    ];

    public static function totalAtivos(){
        return Funcionario::where('ativo', true)->count();
    }

    public static function totalInativos(){
        return Funcionario::where('ativo', false)->count();
    }

    public static function total(){
        return Funcionario::count();
    }

}
