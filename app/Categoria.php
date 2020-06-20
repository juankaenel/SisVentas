<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'categoria';
    protected $primaryKey = 'idcategoria';

    public $timestamps=false;

    protected $fillable = [
        'nombre',
        'descripcion',
        'condicion',
    ];

    protected $guarded = [

    ]; //estos se van a especificar cuando no queremos que se asignen al modelo

    public function articulo()
    {
        //Una Categoria puede tener muchos artículos
        return $this->hasMany(Articulo::class);
    }
}
