<?php

namespace App\Http\Controllers\Api;

use App\Models\Parking;
use App\Models\LocationLog;
use OpenApi\Annotations as OA;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreParkingRequest;
use App\Http\Requests\BuscarParkingRequest;


class ParkingController extends Controller
{

    public function __construct()
    {
        $this->middleware('jwt.auth');
    }
    

    /**
     * @OA\Get(
     *     path="/api/parkings",
     *     summary="Listar parkings paginados",
     *     tags={"3. Parkings"},  
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Lista paginada de parkings",
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
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="nombre", type="string", example="Calle Rivadavia y Santiago"),
     *                         @OA\Property(property="direccion", type="string", example="Calle Rivadavia y Santiago"),
     *                         @OA\Property(property="latitud", type="string", example="-26.8248300"),
     *                         @OA\Property(property="longitud", type="string", example="-65.2001600"),
     *                         @OA\Property(property="created_at", type="string", format="date-time", example="2025-07-31T23:17:59.000000Z"),
     *                         @OA\Property(property="updated_at", type="string", format="date-time", example="2025-07-31T23:17:59.000000Z")
     *                     )
     *                 ),
     *                 @OA\Property(property="first_page_url", type="string", example="http://localhost:8080/api/parkings?page=1"),
     *                 @OA\Property(property="from", type="integer", example=1),
     *                 @OA\Property(property="next_page_url", type="string", example="http://localhost:8080/api/parkings?page=2"),
     *                 @OA\Property(property="path", type="string", example="http://localhost:8080/api/parkings"),
     *                 @OA\Property(property="per_page", type="integer", example=2),
     *                 @OA\Property(property="prev_page_url", type="string", example=null),
     *                 @OA\Property(property="to", type="integer", example=2)
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
        $parking = Parking::orderBy("id","desc")->simplePaginate(10);

        return response()->json([
            'status' => true,
            'data' => $parking,
        ]);

    }


    /**
     * @OA\Post(
     *     path="/api/parkings",  
     *     summary="Crear un nuevo parking",
     *     tags={"3. Parkings"}, 
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nombre", "direccion", "latitud", "longitud"},
     *             @OA\Property(property="nombre", type="string", maxLength=255, example="Parking Centro"),
     *             @OA\Property(property="direccion", type="string", maxLength=500, example="Calle Rivadavia 123"),
     *             @OA\Property(property="latitud", type="number", format="float", example=-26.8241),
     *             @OA\Property(property="longitud", type="number", format="float", example=-65.2226)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Parking creado correctamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Parking creado correctamente"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="nombre", type="string", example="Parking Centro"),
     *                 @OA\Property(property="direccion", type="string", example="Calle Rivadavia 123"),
     *                 @OA\Property(property="latitud", type="number", format="float", example=-26.8241),
     *                 @OA\Property(property="longitud", type="number", format="float", example=-65.2226),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2025-08-01T17:30:00Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2025-08-01T17:30:00Z")
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

    public function store(StoreParkingRequest $request): JsonResponse
    {

        $parking = Parking::create($request->validated());

        return response()->json([
            'status' => true,
            'message' => 'Parking creado correctamente',
            'data' => $parking,
        ], 201);
        
    }



    

    /**
     * @OA\Get(
     *     path="/api/parkings/{id}",
     *     summary="Obtener un parking por ID",
     *     tags={"3. Parkings"},  
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del parking a consultar",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalle del parking",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="nombre", type="string", example="Parking Centro"),
     *                 @OA\Property(property="direccion", type="string", example="Calle Rivadavia 123"),
     *                 @OA\Property(property="latitud", type="number", format="float", example=-26.8241),
     *                 @OA\Property(property="longitud", type="number", format="float", example=-65.2226),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2025-08-01T17:30:00Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2025-08-01T17:30:00Z")
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

    public function show(string $id): JsonResponse
    {

        $parking = Parking::findOrFail($id);

        return response()->json([
            'status' => true,
            'data' => $parking,
        ], 200 );
        
        
    }

    


    /**
     * @OA\Get(
     *     path="/api/buscar-cercano",
     *     summary="Obtener el parking más cercano a una ubicación",
     *     tags={"3. Parkings"},  
     *     security={{"bearerAuth":{}}},
     *     description="Devuelve el parking más cercano según las coordenadas proporcionadas. Si la distancia es mayor a 0.5 km, se registra un log.",
     *     @OA\Parameter(
     *         name="lat",
     *         in="query",
     *         required=true,
     *         description="Latitud del punto de referencia",
     *         @OA\Schema(type="number", format="float", example=-26.8241)
     *     ),
     *     @OA\Parameter(
     *         name="lon",
     *         in="query",
     *         required=true,
     *         description="Longitud del punto de referencia",
     *         @OA\Schema(type="number", format="float", example=-65.2226)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Parking más cercano encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="nombre", type="string", example="Parking Centro"),
     *                 @OA\Property(property="direccion", type="string", example="Calle Rivadavia 123"),
     *                 @OA\Property(property="latitud", type="number", format="float", example=-26.8241),
     *                 @OA\Property(property="longitud", type="number", format="float", example=-65.2226),
     *                 @OA\Property(property="distancia", type="number", format="float", example=0.432),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2025-08-01T17:30:00Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2025-08-01T17:30:00Z")
     *             ),
     *             @OA\Property(property="distancia_km", type="number", format="float", example=0.432)
     *         )
     *     ),
     *     @OA\Response(response="401", ref="#/components/responses/Unauthenticated"),
     *     @OA\Response(response="404", ref="#/components/responses/NotFound"),
     *     @OA\Response(response="422", ref="#/components/responses/ValidationError"),
     *     @OA\Response(response="500", ref="#/components/responses/ServerError"),
     *     @OA\Response(response="405", ref="#/components/responses/MethodNotAllowed") 
     * )
    */
    public function buscarMasCercano(BuscarParkingRequest $request): JsonResponse
    {

        $lat = $request->lat;
        $lng = $request->lon;

        // la distacia en kilometros es calculada en la consulta y redondeado 3 decimales

        /** @var object{distancia: float|null, nombre: string|null}|null $closest */
        $closest = DB::table('parkings')
            ->select(
                '*',
                DB::raw("
                    ROUND(
                        (6371 * acos(
                            cos(radians(?)) * 
                            cos(radians(latitud)) * 
                            cos(radians(longitud) - radians(?)) + 
                            sin(radians(?)) * 
                            sin(radians(latitud))
                        ))::numeric
                    , 3) AS distancia
                ")
            )
            ->whereNotNull('latitud')
            ->whereNotNull('longitud')
            ->orderBy('distancia')
            ->setBindings([$lat, $lng, $lat])
            ->first();
        
        if (!$closest) {
            return response()->json([
                'status' => false, 
                'data' => [],
                'message' => 'No se encontraron parkings',
            ], 200);
        }
        
        if ($closest !== null && $closest->distancia !== null && $closest->distancia > 0.5) {
            LocationLog::create([
                'latitud' => $lat,
                'longitud' => $lng,
                'distancia' => $closest->distancia,
                'parking_nombre' => $closest->nombre ?? null,
            ]);
        }

        return response()->json([
            'status' => true , 
            'data' => $closest,
        ], 200 );
    }












    /**
     * @OA\Delete(
     *     path="/api/parkings/{id}",
     *     summary="Eliminar un parking",
     *     tags={"3. Parkings"},  
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del parking a eliminar",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Parking eliminado",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Parking deleted"),
     *             @OA\Property(property="data", type="array", @OA\Items(type="object"))
     *         )
     *     ),
     *     @OA\Response(response="401", ref="#/components/responses/Unauthenticated"),
     *     @OA\Response(response="404", ref="#/components/responses/NotFound"),
     *     @OA\Response(response="422", ref="#/components/responses/ValidationError"),
     *     @OA\Response(response="500", ref="#/components/responses/ServerError"),
     *     @OA\Response(response="405", ref="#/components/responses/MethodNotAllowed") 
     * )
    */

    public function destroy(string $id): JsonResponse
    {

        Parking::destroy($id);
        return response()->json([
            'status' => true,
            'data' => [],
            'message' => 'Parking deleted'
        ]);
    }
}
