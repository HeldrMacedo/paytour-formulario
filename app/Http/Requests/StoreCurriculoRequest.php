<?php

namespace App\Http\Requests;

use App\Rules\Arquivo;
use App\Rules\ArquivoTipo;
use Illuminate\Foundation\Http\FormRequest;

class StoreCurriculoRequest extends FormRequest
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
            'nome'          => 'required',
            'email'         => 'required',
            'telefone'      => 'required',
            'cargo'         => 'required',
            'escolaridade'  => 'required',
            'arquivo'       => ['required', new Arquivo, new ArquivoTipo],
        ];
    }

    public function messages()
    {
        return [
            'nome.required' => 'O campo nome é obrigatório.',
            'email.required' => 'O campo email é obrigatório.',
            'telefone.required' => 'O campo telefone é obrigatório',
            'cargo.required' => 'O campo cargo desejado é obrigatório.',
            'escolaridade.required' => 'O campo escolaridade é obrigatório.',
            'arquivo.required' => 'O campo arquivo é obrigatório.',
        ];
    }
}
