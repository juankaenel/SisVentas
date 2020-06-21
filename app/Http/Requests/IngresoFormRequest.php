<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IngresoFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id_proveedor'=>'required',
            'tipo_comprobante'=>'required|max=20',
            'serie_comprobante'=>'required|max=7',
            'num_comprobante'=>'required|max=20',
            'id_articulo'=>'required',
            'cantidad'=>'required',
            'precio_compra'=>'required',
            'precio_venta'=>'required'
        ];
    }
}
