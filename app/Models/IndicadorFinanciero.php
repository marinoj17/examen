<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndicadorFinanciero extends Model
{
    use HasFactory;
    protected $fillable =['id', 'nombreIndicador','codigoIndicador','unidadIndicador','valorIndicador','fechaIndicador','tiempoIndicador','origenIndicador', 'unidadMedidaIndicador'];
}
