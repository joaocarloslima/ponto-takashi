<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registro extends Model
{
    use HasFactory;

    protected $fillable = [
        'datahora',
        'funcionario_id',
        'latitude',
        'longitude',
    ];

    public function funcionario()
    {
        return $this->belongsTo(Funcionario::class);
    }

    public function getDataHoraFormatadaAttribute()
    {
        $diasemana = array('dom', 'seg', 'ter', 'qua', 'qui', 'sex', 'sab');
        $diasemana_numero = date('w', strtotime($this->datahora));

        return $diasemana[$diasemana_numero] . ', ' . date('d/m/Y H:i', strtotime($this->datahora));
    }

}
