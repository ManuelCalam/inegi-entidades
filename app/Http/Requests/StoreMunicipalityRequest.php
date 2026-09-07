<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMunicipalityRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'min:2',
                'max:50',
                Rule::unique('municipalities', 'name')->where(function ($query){
                    return $query->where('entity_id', $this->input('entity_id'));
                })
            ],


            'key' => [
                'required',
                'string',
                'min:1',
                'max:4',
                Rule::unique('municipalities', 'key')->where(function ($query) {
                    return $query->where('entity_id', $this->input('entity_id'));
                })
            ],

            'entity_id' => 'required|integer|exists:entities,id'
        ];
    }

     public function messages(): array {
        return [
            // Mensajes para el nombre
            'name.required' => 'Ingresa el nombre del municipio.',
            'name.string' => 'Nombre inválido.',
            'name.max' => 'Nombre inválido.',
            'name.min' => 'Nombre inválido.',
            'name.unique' => 'El municipio ya está registrado en esta entidad federativa',
            
            // Mensajes para la clave
            'key.required' => 'Ingresa la clave correspondiente al municipio.',
            'key.string' => 'Clave inválida.',
            'key.max' => 'Clave inválida.',
            'key.min' => 'Clave inválida.',
            'key.unique' => 'La clave ya está registrado en esta entidad federatitva',

            // Mensajes para el id de la entidad federativa
            'entity_id.required' => 'Selecciona la entidad federativa.',
            'entity_id.integer' => 'Entidad federativa inválida',
            'entity_id.exists' => 'No se encontró la entidad federativa seleccionada.'
        ];
    } 
}
