<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VentaFormRequest extends FormRequest
{
    /*Acá vamos a validar los detalles y la venta*/

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
            'idcliente'=>'required',
            'tipo_comprobante'=>'required|max:20',
            'serie_comprobante'=>'max:7',
            'num_comprobante'=>'required|max:20',
            'idarticulo'=>'required',
            'cantidad'=>'required',
            'precio_venta'=>'required',
            'descuento'=>'required',
            'total_venta'=>'required'
        ];
    }
}
