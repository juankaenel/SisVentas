<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $table = 'persona';
    protected $primaryKey = 'idpersona';

    public $timestamps=false;

    protected $fillable = [
        'idpersona ',
        'tipo_persona',
        'nombre',
        'tipo_documento',
        'num_documento',
        'direccion',
        'telefono',
        'email',
    ];

    protected $guarded = [

    ]; //estos se van a especificar cuando no queremos que se asignen al modelo

}