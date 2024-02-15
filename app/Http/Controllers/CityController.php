<?php

namespace App\Http\Controllers;

use App\Http\Requests\CityRequest;
use App\Models\City;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class CityController extends Controller
{


    const detail_relations = [

    ];


    /**
     * @OA\Get(
     *     path="/api/city",
     *     tags={"City"},
     *     summary="List of cities",
     *     description="Get list of all registered cities",
     *     operationId="listCity",
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
        $query = City::with(self::detail_relations);
        return $this->sendResponsePaginate($query, $request);
    }


    /**
     * Store a newly created resource.
     *
     * @param CityRequest $request
     * @return Response
     *
     * @OA\Post(
     * path="/api/city",
     * summary="create a new city",
     * operationId="newcity",
     * tags={"City"},
     * security={{ "apiAuth": {} }},
     * @OA\RequestBody(
     *    required=true,
     *    description="data to create a new city",
     *    @OA\JsonContent(
    @OA\Property(property="name", type="string", example="Example"),
     *    ),
     * ),
     * @OA\Response(response=201, description="Created city", @OA\JsonContent()),
     * @OA\Response(response=400, description="Bad request", @OA\JsonContent()),
     * @OA\Response(response=422, description="Bad request", @OA\JsonContent()),
     * @OA\Response(response=404, description="Resource Not Found", @OA\JsonContent()),
     * )
     */
    public function store(CityRequest $request): Response
    {
        $city = City::create($request->all());
        return $this->sendResponse($city->load(self::detail_relations), 201);
    }

    /**
     * Show specific resource.
     *
     * @param string $id
     * @return Response
     *
     * @OA\get(
     * path="/api/city/{city}",
     *  @OA\Parameter(description="ID of city", in="path", name="city", required=true,
     *      @OA\Schema(type="integer", format="int64", example="1")
     *  ),
     * summary="Show specific cities",
     * operationId="getCity",
     * tags={"City"},
     * security={{ "apiAuth": {} }},
     * @OA\Response(response=200, description="Operation executed successfully", @OA\JsonContent()),
     * @OA\Response(response=400, description="Bad request", @OA\JsonContent()),
     * @OA\Response(response=404, description="Resource Not Found", @OA\JsonContent()),
     * )
     */
    public function show(string $id): Response
    {
        $city = City::with(self::detail_relations)->findOrFail($id);
        return $this->sendResponse($city);
    }


    /**
     * Update a resource.
     *
     * @param CityRequest $request
     * @param string $id
     * @return Response
     *
     * @OA\Put(
     * path="/api/city/{city}",
     * @OA\Parameter(description="ID of city", in="path", name="city", required=true,
     *      @OA\Schema(type="integer", format="int64", example="1")
     *  ),
     * summary="Update a city",
     * operationId="updateCity",
     * tags={"City"},
     * security={{ "apiAuth": {} }},
     * @OA\RequestBody(
     *    required=true,
     *    description="data to update a city",
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
    public function update(CityRequest $request, string $id): Response
    {
        $city = City::findOrFail($id);
        $city->update($request->all());
        return $this->sendResponse($city->fresh());
    }

    /**
     * Delete a resource.
     *
     * @param string $id
     * @return Response
     * @OA\Delete(
     * path="/api/city/{city}",
     *  @OA\Parameter(description="ID of city", in="path", name="city", required=true,
     *      @OA\Schema(type="integer", format="int64", example="1")
     *  ),
     * summary="Delete a city",
     * operationId="deleteCity",
     * tags={"City"},
     * security={{ "apiAuth": {} }},
     * @OA\Response(response=200, description="Operation executed successfully", @OA\JsonContent()),
     * @OA\Response(response=204, description="Operation executed successfully", @OA\JsonContent()),
     * @OA\Response(response=400, description="Bad request", @OA\JsonContent()),
     * @OA\Response(response=404, description="Resource Not Found", @OA\JsonContent()),
     * )
     */
    public function destroy(string $id): Response
    {
        $city = City::findOrFail($id);
        $city->delete();
        return $this->sendResponse("ok", 204);
    }
}
