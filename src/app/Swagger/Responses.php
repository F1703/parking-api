<?php 

namespace App\Swagger;

/**
 * @OA\Components(
 *     @OA\Response(
 *         response="Unauthenticated",
 *         description="No autenticado o token inválido",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="boolean", example=false),
 *             @OA\Property(property="message", type="string", example="No autenticado. Token no proporcionado o inválido."),
 *             @OA\Property(property="data", type="array", @OA\Items(type="object"))
 *         )
 *     ),
 *     @OA\Response(
 *         response="NotFound",
 *         description="Recurso no encontrado",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="boolean", example=false),
 *             @OA\Property(property="message", type="string", example="Recurso no encontrado"),
 *             @OA\Property(property="data", type="array", @OA\Items(type="object"))
 *         )
 *     ),
 *     @OA\Response(
 *         response="ValidationError",
 *         description="Datos inválidos",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="boolean", example=false),
 *             @OA\Property(property="message", type="string", example="Datos inválidos."),
 *             @OA\Property(property="errors", type="array", @OA\Items(type="object"))
 *         )
 *     ),
 *     @OA\Response(
 *         response="ServerError",
 *         description="Error interno del servidor",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="boolean", example=false),
 *             @OA\Property(property="message", type="string", example="Error interno del servidor"),
 *             @OA\Property(property="data", type="array", @OA\Items(type="object"))
 *         )
 *     ),
 *     @OA\Response(
 *         response="MethodNotAllowed",
 *         description="Método HTTP no permitido",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="boolean", example=false),
 *             @OA\Property(property="message", type="string", example="Método HTTP no permitido para esta ruta.")
 *         )
 *     )
 * )
*/

class Responses
{
    // Esta clase sólo existe para contener las anotaciones generales de OpenAPI
}
