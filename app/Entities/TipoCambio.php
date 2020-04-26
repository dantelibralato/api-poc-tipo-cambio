<?php

namespace App\Entities;

use Jenssegers\Mongodb\Eloquent\Model;

class TipoCambio extends Model 
{
    protected $connection = 'mongodb';
    protected $collection = 'coleccion_tipo_cambio';
    protected $primaryKey = '_id';
}