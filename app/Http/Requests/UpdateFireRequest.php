<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateFireRequest extends FormRequest
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
            'reported_at' => ['required', 'date'],
            'entity_id' => ['required', 'exists:entities,id'],
            'municipality_id' => ['required', 'exists:municipalities,id'],
            'vegetation_type_id' => ['required', 'exists:vegetation_types,id'],
            'fire_status' => ['required', 'string', 'max:50'],
            'start_date' => ['required', 'date'],
            'extinction_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'duration_days' => ['required', 'integer', 'min:0'],
            'control_percentage' => ['required', 'numeric', 'min:0', 'max:100'],
            'extinction_percentage' => ['required', 'numeric', 'min:0', 'max:100'],
        ];
    }

    public function messages(): array
    {
        return [
            // Fecha y hora de reporte
            'reported_at.required' => 'La fecha y hora de reporte son obligatorias.',
            'reported_at.date' => 'La fecha de reporte debe ser una fecha válida.',

            // Entidad federativa
            'entity_id.required' => 'Debes seleccionar una entidad federativa.',
            'entity_id.exists' => 'La entidad federativa seleccionada no es válida.',

            // Municipio
            'municipality_id.required' => 'Debes seleccionar un municipio.',
            'municipality_id.exists' => 'El municipio seleccionado no es válido.',

            // Tipo de vegetación
            'vegetation_type_id.required' => 'Debes seleccionar un tipo de vegetación.',
            'vegetation_type_id.exists' => 'El tipo de vegetación seleccionado no es válido.',

            // Estado del incendio
            'fire_status.required' => 'El estado del incendio es obligatorio.',
            'fire_status.string' => 'El estado del incendio debe ser texto válido.',
            'fire_status.max' => 'El estado del incendio no puede tener más de 50 caracteres.',

            // Fecha de inicio
            'start_date.required' => 'La fecha de inicio es obligatoria.',
            'start_date.date' => 'La fecha de inicio debe ser una fecha válida.',

            // Fecha de liquidación
            'extinction_date.date' => 'La fecha de liquidación debe ser una fecha válida.',
            'extinction_date.after_or_equal' => 'La fecha de liquidación debe ser igual o posterior a la fecha de inicio.',

            // Días de duración
            'duration_days.required' => 'El número de días de duración es obligatorio.',
            'duration_days.integer' => 'Los días de duración deben ser un número entero.',
            'duration_days.min' => 'Los días de duración no pueden ser un valor negativo.',

            // Porcentaje de control
            'control_percentage.required' => 'El porcentaje de control es obligatorio.',
            'control_percentage.numeric' => 'El porcentaje de control debe ser un valor numérico.',
            'control_percentage.min' => 'El porcentaje de control no puede ser menor a 0.',
            'control_percentage.max' => 'El porcentaje de control no puede ser mayor a 100.',

            // Porcentaje de liquidación
            'extinction_percentage.required' => 'El porcentaje de liquidación es obligatorio.',
            'extinction_percentage.numeric' => 'El porcentaje de liquidación debe ser un valor numérico.',
            'extinction_percentage.min' => 'El porcentaje de liquidación no puede ser menor a 0.',
            'extinction_percentage.max' => 'El porcentaje de liquidación no puede ser mayor a 100.',
        ];
    }
}
