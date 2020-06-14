<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoriaFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; /*Si está autorizado para hacer el request*/
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        /*Para agregar las reglas debemos revisar las bd*/
        return [ /*el nombre y la descripcion son objetos, que son los que van en el formulario que vamos a recibir. no son los mismos q los de la bd.*/
            'nombre' => 'required|max:50',
            'descripcion' => 'required|max:256',
        ];
    }
}
