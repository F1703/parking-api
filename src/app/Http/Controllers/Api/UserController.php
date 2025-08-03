<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;


class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('jwt.auth');
    }


    /**
     * @OA\Get(
     *     path="/api/users",
     *     summary="Listar usuarios paginados",
     *     tags={"2. Usuarios"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Listado exitoso",
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
    public function index(): JsonResponse
    {
        $parking = User::orderBy("id", "desc")->simplePaginate(10);
        return response()->json([
            'status' => true,
            'data' => $parking,
        ]);
    }


    /**
     * @OA\Post(
     *     path="/api/users",
     *     summary="Crear un nuevo usuario",
     *     tags={"2. Usuarios"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "email", "password"},
     *             @OA\Property(property="name", type="string", example="Juan Pérez"),
     *             @OA\Property(property="email", type="string", example="juan@example.com"),
     *             @OA\Property(property="password", type="string", example="secret123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Usuario creado",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/User")
     *         )
     *     ),
     *     @OA\Response(response="401", ref="#/components/responses/Unauthenticated"),
     *     @OA\Response(response="404", ref="#/components/responses/NotFound"),
     *     @OA\Response(response="422", ref="#/components/responses/ValidationError"),
     *     @OA\Response(response="500", ref="#/components/responses/ServerError"),
     *     @OA\Response(response="405", ref="#/components/responses/MethodNotAllowed") 
     * )
     */
    public function store(StoreUserRequest $request): JsonResponse
    {
        $data = $request->validated();
        if (isset($data['password']) && is_string($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }
        $user = User::create($data);

        return response()->json(['status' => true, 'data' => $user]);
    }


    /**
     * @OA\Get(
     *     path="/api/users/{id}",
     *     summary="Obtener un usuario por ID",
     *     tags={"2. Usuarios"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del usuario",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Usuario encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/User")
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
        $user = User::findOrFail($id);
        return response()->json([
            'status' => true,
            'data' => $user,
        ]);
    }

    /**
     * @OA\Put(
     *     path="/api/users/{id}",
     *     summary="Actualizar un usuario",
     *     tags={"2. Usuarios"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del usuario a actualizar",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=false,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="Nuevo Nombre"),
     *             @OA\Property(property="email", type="string", example="nuevo@email.com"),
     *             @OA\Property(property="password", type="string", example="nueva1234")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Usuario actualizado",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/User")
     *         )
     *     ),
     *     @OA\Response(response="401", ref="#/components/responses/Unauthenticated"),
     *     @OA\Response(response="404", ref="#/components/responses/NotFound"),
     *     @OA\Response(response="422", ref="#/components/responses/ValidationError"),
     *     @OA\Response(response="500", ref="#/components/responses/ServerError"),
     *     @OA\Response(response="405", ref="#/components/responses/MethodNotAllowed") 
     * )
     */

    public function update(UpdateUserRequest $request, string $id): JsonResponse
    {
        $user = User::findOrFail($id);

        $data = $request->validated();
        if (isset($data['password']) && is_string($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }

        $user->update(array_filter($data));

        return response()->json(['status' => true, 'data' => $user]);
    }


    /**
     * @OA\Delete(
     *     path="/api/users/{id}",
     *     summary="Eliminar un usuario",
     *     tags={"2. Usuarios"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del usuario a eliminar",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Usuario eliminado",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="User deleted"),
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
        User::destroy($id);
        return response()->json([
            'status' => true,
            'data' => [],
            'message' => 'User deleted'
        ]);
    }
}
