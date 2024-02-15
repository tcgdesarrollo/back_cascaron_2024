<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use App\Models\Role;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class RoleController extends Controller
{


    const detail_relations = [

    ];


    /**
     * @OA\Get(
     *     path="/api/role",
     *     tags={"Role"},
     *     summary="List of roles",
     *     description="Get list of all registered roles",
     *     operationId="listRole",
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *          @OA\JsonContent()
     *     ),
     *       security={{ "apiAuth": {} }}
     *     ),
     */
    public function index(Request $request)
    {
        $query = Role::with(self::detail_relations);
        return $this->sendResponsePaginate($query, $request);
    }


    /**
     * Store a newly created resource.
     *
     * @param RoleRequest $request
     * @return Response
     *
     * @OA\Post(
     * path="/api/role",
     * summary="create a new role",
     * operationId="newrole",
     * tags={"Role"},
     * security={{ "apiAuth": {} }},
     * @OA\RequestBody(
     *    required=true,
     *    description="data to create a new role",
     *    @OA\JsonContent(
    @OA\Property(property="name", type="string", example="Example"),
     *    ),
     * ),
     * @OA\Response(response=201, description="Created role", @OA\JsonContent()),
     * @OA\Response(response=400, description="Bad request", @OA\JsonContent()),
     * @OA\Response(response=422, description="Bad request", @OA\JsonContent()),
     * @OA\Response(response=404, description="Resource Not Found", @OA\JsonContent()),
     * )
     */
    public function store(RoleRequest $request): Response
    {
        $role = Role::create($request->all());
        return $this->sendResponse($role->load(self::detail_relations), 201);
    }

    /**
     * Show specific resource.
     *
     * @param string $id
     * @return Response
     *
     * @OA\get(
     * path="/api/role/{role}",
     *  @OA\Parameter(description="ID of role", in="path", name="role", required=true,
     *      @OA\Schema(type="integer", format="int64", example="1")
     *  ),
     * summary="Show specific roles",
     * operationId="getRole",
     * tags={"Role"},
     * security={{ "apiAuth": {} }},
     * @OA\Response(response=200, description="Operation executed successfully", @OA\JsonContent()),
     * @OA\Response(response=400, description="Bad request", @OA\JsonContent()),
     * @OA\Response(response=404, description="Resource Not Found", @OA\JsonContent()),
     * )
     */
    public function show(string $id): Response
    {
        $role = Role::with(self::detail_relations)->findOrFail($id);
        return $this->sendResponse($role);
    }


    /**
     * Update a resource.
     *
     * @param RoleRequest $request
     * @param string $id
     * @return Response
     *
     * @OA\Put(
     * path="/api/role/{role}",
     * @OA\Parameter(description="ID of role", in="path", name="role", required=true,
     *      @OA\Schema(type="integer", format="int64", example="1")
     *  ),
     * summary="Update a role",
     * operationId="updateRole",
     * tags={"Role"},
     * security={{ "apiAuth": {} }},
     * @OA\RequestBody(
     *    required=true,
     *    description="data to update a role",
     *    @OA\JsonContent(
     *       @OA\Property(property="name", type="string", example="Example"),
     *    ),
     * ),
     * @OA\Response(response=200, description="Operation executed successfully", @OA\JsonContent()),
     * @OA\Response(response=400, description="Bad request", @OA\JsonContent()),
     * @OA\Response(response=422, description="Bad request", @OA\JsonContent()),
     * @OA\Response(response=404, description="Resource Not Found", @OA\JsonContent()),
     * )
     */
    public function update(RoleRequest $request, string $id): Response
    {
        $role = Role::findOrFail($id);
        $role->update($request->all());
        return $this->sendResponse($role->fresh());
    }

    /**
     * Delete a resource.
     *
     * @param string $id
     * @return Response
     * @OA\Delete(
     * path="/api/role/{role}",
     *  @OA\Parameter(description="ID of role", in="path", name="role", required=true,
     *      @OA\Schema(type="integer", format="int64", example="1")
     *  ),
     * summary="Delete a role",
     * operationId="deleteRole",
     * tags={"Role"},
     * security={{ "apiAuth": {} }},
     * @OA\Response(response=200, description="Operation executed successfully", @OA\JsonContent()),
     * @OA\Response(response=204, description="Operation executed successfully", @OA\JsonContent()),
     * @OA\Response(response=400, description="Bad request", @OA\JsonContent()),
     * @OA\Response(response=404, description="Resource Not Found", @OA\JsonContent()),
     * )
     */
    public function destroy(string $id): Response
    {
        $role = Role::findOrFail($id);
        $role->delete();
        return $this->sendResponse("ok", 204);
    }
}
