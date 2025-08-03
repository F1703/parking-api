<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Tymon\JWTAuth\JWTAuth;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;

class RegisterController extends Controller
{

    public function __construct(private JWTAuth $jwtAuth) {}

    /**
     * @OA\Post(
     *     path="/api/register",
     *     summary="Registrar un nuevo usuario",
     *     tags={"1. Autenticación"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "email", "password", "password_confirmation"},
     *             @OA\Property(property="name", type="string", example="Juan Pérez"),
     *             @OA\Property(property="email", type="string", example="juan@example.com"),
     *             @OA\Property(property="password", type="string", example="secret123"),
     *             @OA\Property(property="password_confirmation", type="string", example="secret123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Usuario registrado exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example="true"),
     *             @OA\Property(property="token", type="string", example="eyJ0eXAiOiJKV1Qi...")
     *         )
     *     ),
     *     @OA\Response(response="401", ref="#/components/responses/Unauthenticated"),
     *     @OA\Response(response="404", ref="#/components/responses/NotFound"),
     *     @OA\Response(response="422", ref="#/components/responses/ValidationError"),
     *     @OA\Response(response="500", ref="#/components/responses/ServerError"),
     *     @OA\Response(response="405", ref="#/components/responses/MethodNotAllowed") 
     * )
    */

    public function register(RegisterRequest $request): JsonResponse
    {
        if (isset($request['password']) && is_string($request['password'])) {
            $request['password'] = bcrypt($request['password']);
        }

        $user = User::create([
            'name'     => $request['name'],
            'email'    => $request['email'],
            'password' => $request['password'],
        ]);

        $token = $this->jwtAuth->fromUser($user);

        return response()->json(['status' => true, 'token' => $token], 201);
    }

}