<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];


    public function register(): void
    {
        
        $this->reportable(function (Throwable $e) {
            //
        });

       
        # Controlar las excepciones JWT
        $this->renderable(function (AuthenticationException $e, $request) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'status' => false,
                    'data' => [],
                    'message' => 'No autenticado. Token no proporcionado o inválido.',
                ], 401);
            }
        });

        $this->renderable(function (TokenExpiredException $e, $request) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'status' => false,
                    'data' => [],
                    'message' => 'El token ha expirado.',
                ], 401);
            }
        });

        $this->renderable(function (TokenInvalidException $e, $request) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'status' => false,
                    'data' => [],
                    'message' => 'El token es inválido.',
                ], 401);
            }
        });

        $this->renderable(function (JWTException $e, $request) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'status' => false,
                    'data' => [],
                    'message' => 'Token no proporcionado.',
                ], 401);
            }
        });
        
        $this->renderable(function (UnauthorizedHttpException $e, $request) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'status' => false,
                    'data' => [],
                    'message' => 'No se proporcionó un token válido.',
                ], 401);
            }
        });


        $this->renderable(function (MethodNotAllowedHttpException $e, $request) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'status' => false,
                    'data' => [],
                    'message' => 'Método HTTP no permitido para esta ruta.',
                ], 405); // 405 Method Not Allowed
            }
        });



        





        

        $this->renderable(function (ValidationException $e, $request) {
            if ($request->is('api/documentation') || $request->is('api-docs.json')) {
                return; 
            }
            
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'status' => false,
                    'data' => [], 
                    'message' => 'Datos inválidos.' ,
                    'errors' => $e->errors(),
                ], 422);
            }
        });

        $this->renderable(function (ModelNotFoundException|NotFoundHttpException $e, $request) {
            if ($request->is('api/documentation') || $request->is('api-docs.json')) {
                return; 
            }

            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'status' => false,
                    'data' => [], 
                    'message' => 'Recurso no encontrado',
                ], 404);
            }
        });

        $this->renderable(function (Throwable $e, $request) {
            if ($request->is('api/documentation') || $request->is('api-docs.json')) {
                return; 
            }

            if ($request->expectsJson() || $request->is('api/*')) {

                // cualquier otro tipo de excepcion capturar y crear log. (para luego crear una respuesta personalizada)
                Log::error('Excepción no capturada:', [
                    'class' => get_class($e),
                    'message' => $e->getMessage(),
                ]);

                return response()->json([
                    'status' => false,
                    'data' => [],
                    'message' => 'Error interno del servidor',
                ], 500);
            }
            
           
        });





        
    }
}
