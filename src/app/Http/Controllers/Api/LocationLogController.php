<?php

namespace App\Http\Controllers\Api;

use App\Models\LocationLog;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class LocationLogController extends Controller
{

    public function __construct()
    {
        $this->middleware('jwt.auth');
    }
    

    /**
     * @OA\Get(
     *     path="/api/logs/distantes",
     *     summary="Listar logs de ubicaciones con distancias mayores a 0.5 km",
     *     tags={"4. Logs"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Lista paginada de logs de ubicaciones (puede estar vacía)",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="current_page", type="integer", example=1),
     *                 @OA\Property(
     *                     property="data",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="id", type="integer", example=7),
     *                         @OA\Property(property="latitud", type="string", example="-26.8613400"),
     *                         @OA\Property(property="longitud", type="string", example="-65.1700000"),
     *                         @OA\Property(property="distancia", type="string", example="4.848"),
     *                         @OA\Property(property="parking_nombre", type="string", example="Calle Rivadavia y Cordoba"),
     *                         @OA\Property(property="created_at", type="string", format="date-time", example="2025-08-01T20:36:36.000000Z"),
     *                         @OA\Property(property="updated_at", type="string", format="date-time", example="2025-08-01T20:36:36.000000Z"),
     *                     )
     *                 ),
     *                 @OA\Property(property="first_page_url", type="string", example="http://localhost:8080/api/logs/distantes?page=1"),
     *                 @OA\Property(property="from", type="integer", nullable=true, example=1),
     *                 @OA\Property(property="next_page_url", type="string", nullable=true, example="http://localhost:8080/api/logs/distantes?page=2"),
     *                 @OA\Property(property="path", type="string", example="http://localhost:8080/api/logs/distantes"),
     *                 @OA\Property(property="per_page", type="integer", example=2),
     *                 @OA\Property(property="prev_page_url", type="string", nullable=true, example=null),
     *                 @OA\Property(property="to", type="integer", nullable=true, example=2),
     *             )
     *         )
     *     ),
     *     @OA\Response(response="401", ref="#/components/responses/Unauthenticated"),
     *     @OA\Response(response="404", ref="#/components/responses/NotFound"),
     *     @OA\Response(response="422", ref="#/components/responses/ValidationError"),
     *     @OA\Response(response="500", ref="#/components/responses/ServerError"),
     *     @OA\Response(response="405", ref="#/components/responses/MethodNotAllowed") 
     * )
    */
    public function index(): JsonResponse
    {
        $logs = LocationLog::orderByDesc('created_at')->simplePaginate(10);

        return response()->json([
            'status' => true,
            'data' => $logs,
        ]);

    }


}
