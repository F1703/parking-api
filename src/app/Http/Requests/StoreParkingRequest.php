<?php

namespace App\Http\Requests;

use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class StoreParkingRequest extends FormRequest
{
   
    public function authorize(): bool
    {
        return true;
    }

 
    /**
     * @return array<string, string>
    */ 
    public function rules(): array
    {
        return [
            'nombre' => 'required|string|max:255',
            'direccion' => 'required|string|max:500',
            'latitud' => 'required|numeric|between:-90,90',
            'longitud' => 'required|numeric|between:-180,180',
        ];
    }

    /**
     * @return array<string, string>
    */ 
    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre del parking es obligatorio.',
            'nombre.string' => 'El nombre debe ser un texto válido.',
            'nombre.max' => 'El nombre no puede exceder los 255 caracteres.',

            'direccion.required' => 'La dirección es obligatoria.',
            'direccion.string' => 'La dirección debe ser un texto válido.',
            'direccion.max' => 'La dirección no puede exceder los 500 caracteres.',

            'latitud.required' => 'La latitud es obligatoria.',
            'latitud.numeric' => 'La latitud debe ser un número válido.',
            'latitud.between' => 'La latitud debe estar entre -90 y 90.',

            'longitud.required' => 'La longitud es obligatoria.',
            'longitud.numeric' => 'La longitud debe ser un número válido.',
            'longitud.between' => 'La longitud debe estar entre -180 y 180.',

        ];
    }



    public function failedValidation(Validator $validator): JsonResponse
    {
        $response = response()->json([
            'status' => false,
            'message' => 'Datos inválidos',
            'errors' => $validator->errors()
        ], 422);

        throw new ValidationException($validator, $response);
    }



}
