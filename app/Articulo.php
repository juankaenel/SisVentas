<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{

    protected $table = 'articulo';
    protected $primaryKey = 'idarticulo';

    public $timestamps=false;

    protected $fillable = [
        'idcategoria',
        'codigo',
        'nombre',
        'stock',
        'descripcion',
        'imagen',
        'estado'
    ];

    protected $guarded = [

    ]; //estos se van a especificar cuando no queremos que se asignen al modelo

    public function categoria()
    {
        //Un Articulo puede pertenecer a una Categoria
        //belongsTo(Categoria::class) relaciona con categoriaid por default
        return $this->belongsTo(Categoria::class, 'idcategoria');
    }
}
