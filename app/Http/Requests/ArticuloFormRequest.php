<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticuloFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'idcategoria'=>'required',
            'codigo' => 'required|max:50',
            'nombre'=>'required|max:50',
            'stock'=>'required|numeric',
            'descripcion' => 'max:256',
            /*'estado' => 'max:20',*/
            'imagen'=>'mimes:jpeg,bmp,png' //si no sube este tipo de archivos habrá un error en la validación
        ];
    }
}
