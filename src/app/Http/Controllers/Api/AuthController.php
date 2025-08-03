<?php

namespace App\Http\Controllers\Api;

use Tymon\JWTAuth\JWTAuth;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    public function __construct(private JWTAuth $jwtAuth) {}

    /**
     * @OA\Post(
     *     path="/api/login",
     *     summary="Iniciar sesión",
     *     tags={"1. Autenticación"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "password"},
     *             @OA\Property(property="email", type="string", example="juan@example.com"),
     *             @OA\Property(property="password", type="string", example="secret123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Inicio de sesión exitoso",
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
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');

        try {
            $token = $this->jwtAuth->attempt($credentials);
            if (!$token) {
                return response()->json(['status' => false, 'message' => 'Credenciales inválidas'], 401);
            }

            return response()->json(['status' => true, 'token' => $token]);
        } catch (JWTException $e) {
            return response()->json(['status' => false, 'message' => 'Error al crear el token'], 500);
        }

    }


    /**
     * @OA\Get(
     *     path="/api/me",
     *     summary="Obtener el usuario autenticado",
     *     tags={"1. Autenticación"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Datos del usuario autenticado",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/User"))
     *         )
     *     ),
     *     @OA\Response(response="401", ref="#/components/responses/Unauthenticated"),
     *     @OA\Response(response="404", ref="#/components/responses/NotFound"),
     *     @OA\Response(response="422", ref="#/components/responses/ValidationError"),
     *     @OA\Response(response="500", ref="#/components/responses/ServerError"),
     *     @OA\Response(response="405", ref="#/components/responses/MethodNotAllowed") 
     * )
    */
    public function me(): JsonResponse
    {
        
        return response()->json([
            'status' => true,
            'user' => $this->jwtAuth->user()
        ]);

    }



    /**
     * @OA\Post(
     *     path="/api/logout",
     *     summary="Cerrar sesión del usuario autenticado",
     *     tags={"1. Autenticación"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Cierre de sesión exitoso",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Successfully logged out")
     *         )
     *     ), 
     *     @OA\Response(response="401", ref="#/components/responses/Unauthenticated"),
     *     @OA\Response(response="404", ref="#/components/responses/NotFound"),
     *     @OA\Response(response="422", ref="#/components/responses/ValidationError"),
     *     @OA\Response(response="500", ref="#/components/responses/ServerError"),
     *     @OA\Response(response="405", ref="#/components/responses/MethodNotAllowed") 
     * )
    */
    public function logout(): JsonResponse
    {

        try {
            $this->jwtAuth->invalidate(true);
            return response()->json(['status' => true, 'message' => 'Sesión cerrada']);
        } catch (JWTException $e) {
            return response()->json(['status' => false, 'message' => 'No se pudo invalidar el token'], 500);
        }
        
    }
}
