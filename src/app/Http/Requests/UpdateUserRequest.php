<?php

namespace App\Http\Requests;

use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateUserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'     => 'nullable|string|max:255',
            'email'    => 'nullable|email|unique:users,email,' . $this->route('user'),
            'password' => 'nullable|string|min:6',
        ];
    }


    /**
     * @return array<string, string>
    */
    public function messages(): array
    {
        return [
            'email.email'    => 'El formato del correo electrónico no es válido.',
            'email.unique'   => 'Este correo electrónico ya está registrado por otro usuario.',
            'password.min'   => 'La contraseña debe tener al menos 6 caracteres.',
        ];
    }


    public function failedValidation(Validator $validator): void
    {
        $response = response()->json([
            'status' => false,
            'message' => 'Datos inválidos',
            'errors' => $validator->errors()
        ], 422);

        throw new HttpResponseException($response);
    }



    
}
