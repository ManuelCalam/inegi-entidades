<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreEntityRequest extends FormRequest
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
            'name'                => 'required|string|max:50|min:6|unique:entities,name',
            'key'                 => 'required|string|max:2|min:1|unique:entities,key',
            'regional_center'     => 'required|string',
            'bordering_entities'  => 'array|min:1',
            'bordering_entities.*' => 'string',
            'vegetation_types'    => 'required|array|min:1',
            'vegetation_types.*'  => 'integer|exists:vegetation_types,id',
        ];
    }

    public function messages(): array 
    {
        return [
            // Mensajes para el nombre
            'name.required' => 'Ingresa el nombre de la entidad federativa.',
            'name.string' => 'Nombre inválido.',
            'name.max' => 'Nombre inválido.',
            'name.min' => 'Nombre inválido.',
            'name.unique' => 'La entidad federativa ya está registrada.',
            
            // Mensajes para la clave
            'key.required' => 'Ingresa la clave correspondiente a la entidad federativa.',
            'key.string' => 'Clave inválida.',
            'key.max' => 'Clave inválida.',
            'key.min' => 'Clave inválida.',
            'key.unique' => 'La clave ya está asociada a otra entidad federativa.',

            // Mensajes para el centro regional
            'regional_center.required' => 'Selecciona el centro regional.',
            'regional_center.string' => 'Centro regional inválido.',

            // Mensajes para entidades colindantes
            'bordering_entities.array' => 'Entidades colindantes inválidas.',
            'bordering_entities.min' => 'Selecciona al menos una entidad colindante.',

            // Mensajes para tipos de vegetación
            'vegetation_types.required' => 'Selecciona los tipos de vegetación.',
            'vegetation_types.array'    => 'Tipos de vegetación inválidos.',
            'vegetation_types.min'      => 'Selecciona al menos un tipo de vegetación.',
            'vegetation_types.*.integer' => 'Tipo de vegetación inválido.',
            'vegetation_types.*.exists' => 'El tipo de vegetación seleccionado no existe.',
        ];
    }
}