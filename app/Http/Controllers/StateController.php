<?php

namespace App\Http\Controllers;

use App\Http\Requests\StateRequest;
use App\Models\State;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class StateController extends Controller
{


    const detail_relations = [

    ];


    /**
     * @OA\Get(
     *     path="/api/state",
     *     tags={"State"},
     *     summary="List of states",
     *     description="Get list of all registered states",
     *     operationId="listState",
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
        $query = State::with(self::detail_relations);
        return $this->sendResponsePaginate($query, $request);
    }


    /**
     * Store a newly created resource.
     *
     * @param StateRequest $request
     * @return Response
     *
     * @OA\Post(
     * path="/api/state",
     * summary="create a new state",
     * operationId="newstate",
     * tags={"State"},
     * security={{ "apiAuth": {} }},
     * @OA\RequestBody(
     *    required=true,
     *    description="data to create a new state",
     *    @OA\JsonContent(
    @OA\Property(property="name", type="string", example="Example"),
     *    ),
     * ),
     * @OA\Response(response=201, description="Created state", @OA\JsonContent()),
     * @OA\Response(response=400, description="Bad request", @OA\JsonContent()),
     * @OA\Response(response=422, description="Bad request", @OA\JsonContent()),
     * @OA\Response(response=404, description="Resource Not Found", @OA\JsonContent()),
     * )
     */
    public function store(StateRequest $request): Response
    {
        $state = State::create($request->all());
        return $this->sendResponse($state->load(self::detail_relations), 201);
    }

    /**
     * Show specific resource.
     *
     * @param string $id
     * @return Response
     *
     * @OA\get(
     * path="/api/state/{state}",
     *  @OA\Parameter(description="ID of state", in="path", name="state", required=true,
     *      @OA\Schema(type="integer", format="int64", example="1")
     *  ),
     * summary="Show specific states",
     * operationId="getState",
     * tags={"State"},
     * security={{ "apiAuth": {} }},
     * @OA\Response(response=200, description="Operation executed successfully", @OA\JsonContent()),
     * @OA\Response(response=400, description="Bad request", @OA\JsonContent()),
     * @OA\Response(response=404, description="Resource Not Found", @OA\JsonContent()),
     * )
     */
    public function show(string $id): Response
    {
        $state = State::with(self::detail_relations)->findOrFail($id);
        return $this->sendResponse($state);
    }


    /**
     * Update a resource.
     *
     * @param StateRequest $request
     * @param string $id
     * @return Response
     *
     * @OA\Put(
     * path="/api/state/{state}",
     * @OA\Parameter(description="ID of state", in="path", name="state", required=true,
     *      @OA\Schema(type="integer", format="int64", example="1")
     *  ),
     * summary="Update a state",
     * operationId="updateState",
     * tags={"State"},
     * security={{ "apiAuth": {} }},
     * @OA\RequestBody(
     *    required=true,
     *    description="data to update a state",
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
    public function update(StateRequest $request, string $id): Response
    {
        $state = State::findOrFail($id);
        $state->update($request->all());
        return $this->sendResponse($state->fresh());
    }

    /**
     * Delete a resource.
     *
     * @param string $id
     * @return Response
     * @OA\Delete(
     * path="/api/state/{state}",
     *  @OA\Parameter(description="ID of state", in="path", name="state", required=true,
     *      @OA\Schema(type="integer", format="int64", example="1")
     *  ),
     * summary="Delete a state",
     * operationId="deleteState",
     * tags={"State"},
     * security={{ "apiAuth": {} }},
     * @OA\Response(response=200, description="Operation executed successfully", @OA\JsonContent()),
     * @OA\Response(response=204, description="Operation executed successfully", @OA\JsonContent()),
     * @OA\Response(response=400, description="Bad request", @OA\JsonContent()),
     * @OA\Response(response=404, description="Resource Not Found", @OA\JsonContent()),
     * )
     */
    public function destroy(string $id): Response
    {
        $state = State::findOrFail($id);
        $state->delete();
        return $this->sendResponse("ok", 204);
    }
}
