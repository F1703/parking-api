<?php 

namespace App\Swagger;

/**
 * @OA\Info(
 *     title="Parking Seeker API",
 *     version="1.0.0",
 *     description="API para la gestión de parkings, incluyendo creación, consulta por ID y búsqueda del parking más cercano a una ubicación geográfica. También registra ubicaciones cuando no se encuentra un parking a menos de 500 metros.",
 * )
 *
 * @OA\Server(
 *     url=L5_SWAGGER_CONST_HOST,
 *     description="Servidor local de desarrollo"
 * )
*/

class Base
{
    // Esta clase sólo existe para contener las anotaciones generales de OpenAPI
}
