<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class BuscarParkingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true ;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'lat' => 'required|numeric|between:-90,90',
            'lon' => 'required|numeric|between:-180,180',
        ];
    }


    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'lat.required' => 'La latitud es obligatoria.',
            'lat.numeric' => 'La latitud debe ser un valor numérico.',
            'lat.between' => 'La latitud debe estar entre -90 y 90.',
            'lon.required' => 'La longitud es obligatoria.',
            'lon.numeric' => 'La longitud debe ser un valor numérico.',
            'lon.between' => 'La longitud debe estar entre -180 y 180.',
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
