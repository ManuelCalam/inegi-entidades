<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMunicipalityRequest extends FormRequest
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
        $municipality = $this->route('municipality');
        $entity_id = $this->input('entity_id', $municipality->entity_id);

        return [
            'name' => [
                'sometimes',
                'required',
                'string',
                'max:50',
                'min:2',
                Rule::unique('municipalities', 'name')->where('entity_id', $entity_id)->ignore($municipality->id)
            ],

            'key' => [
                'sometimes',
                'required',
                'string',
                'max:4',
                'min:1',
                Rule::unique('municipalities', 'key')->where('entity_id', $entity_id)->ignore($municipality->id)
            ],

            'entity_id' => [
                'sometimes',
                'required',
                'integer',
                'exists:entities,id'
            ]
        ];
    }

    public function messages(): array {
        return [
            // Mensajes para el nombre
            'name.required' => 'Ingresa el nombre del municipio.',
            'name.string' => 'Nombre inválido.',
            'name.max' => 'Nombre inválido.',
            'name.min' => 'Nombre inválido.',
            'name.unique' => 'El municipio ya está registrado en esta entidad federativa.',
            
            // Mensajes para la clave
            'key.required' => 'Ingresa la clave correspondiente al municipio.',
            'key.string' => 'Clave inválida.',
            'key.max' => 'Clave inválida.',
            'key.min' => 'Clave inválida.',
            'key.unique' => 'La clave ya está registrada en esta entidad federativa.',

            // Mensajes para el id de la entidad federativa
            'entity_id.required' => 'Selecciona la entidad federativa.',
            'entity_id.integer' => 'Entidad federativa inválida',
            'entity_id.exists' => 'No se encontró la entidad federativa seleccionada.'
        ];
    } 
}
