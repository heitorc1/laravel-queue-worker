<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Data extends Model
{
    use HasFactory;

    protected $table = 'iptu';

    protected $fillable = [
        'nrinscr',
        'cdlogradou',
        'tplogradou',
        'nmlogradou',
        'nrimovel',
        'incompl',
        'nrquadra',
        'nrlote',
        'cdbairro',
        'nmbairro',
        'insubprinc',
        'ttsublot',
        'nrfrenter',
        'areaterr',
        'areatest',
        'areaedif',
        'propriedad',
        'situacao',
        'topografia',
        'nivel',
        'solo',
        'uso',
        'uso1',
        'formauso',
        'localizac',
        'nrelevador',
        'nrgaragem',
        'tpedif1',
        'tpedif2',
        'posicaoedf',
        'estrutura',
        'esquadria',
        'piso',
        'forro',
        'insteletri',
        'ininstsani',
        'revinterno',
        'acinterno',
        'revexterno',
        'acexterno',
        'cobertura',
        'conserva',
        'agua',
        'esgoto',
        'ocupacao',
        'fecho',
        'passeio',
        'nrarvores',
        'nrpostes',
        'cdedificio',
        'vlvenal',
        'nrpaviment',
        'nrvagascob',
        'nrvagasdes',
        'nmedificio',
        'pontedific',
        'VALR_M2_EDF_LAN',
        'VALR_M2_TERRENO_LAN',
        'VALR_M2_ZPA_LAN'
    ];
}
