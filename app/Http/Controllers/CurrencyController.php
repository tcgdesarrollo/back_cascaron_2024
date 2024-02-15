<?php

namespace App\Http\Controllers;

use App\Http\Requests\CurrencyRequest;
use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use OpenApi\Annotations as OA;

class CurrencyController extends Controller
{
    const relations = [];

    /**
     * @OA\Get(
     *     path="/api/currency",
     *     tags={"Currency"},
     *     summary="List of currencies",
     *     description="Get list of all registered currencies",
     *     operationId="listCurrency",
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
        $query = Currency::with(self::relations);
        return $this->sendResponsePaginate($query, $request);
    }


    /**
     * Store a newly created resource.
     *
     * @param CurrencyRequest $request
     * @return Response
     *
     * @OA\Post(
     * path="/api/currency",
     * summary="create a new currency",
     * operationId="newcurrency",
     * tags={"Currency"},
     * security={{ "apiAuth": {} }},
     * @OA\RequestBody(
     *    required=true,
     *    description="data to create a new currency",
     *    @OA\JsonContent(
    @OA\Property(property="name", type="string", example="Example"),
    @OA\Property(property="code", type="string", example="ex"),
    @OA\Property(property="num", type="string", example="2"),
    @OA\Property(property="symbol", type="char", example="ex"),
    @OA\Property(property="symbol_native", type="char", example="e"),
    @OA\Property(property="num_decimals", type="integer", example="2"),
     *    ),
     * ),
     * @OA\Response(response=201, description="Created currency", @OA\JsonContent()),
     * @OA\Response(response=400, description="Bad request", @OA\JsonContent()),
     * @OA\Response(response=422, description="Bad request", @OA\JsonContent()),
     * @OA\Response(response=404, description="Resource Not Found", @OA\JsonContent()),
     * )
     */
    public function store(CurrencyRequest $request): Response
    {
        $currency = Currency::create($request->all());
        return $this->sendResponse($currency->load(self::relations), 201);
    }

    /**
     * Show specific resource.
     *
     * @param string $id
     * @return Response
     *
     * @OA\get(
     * path="/api/currency/{currency}",
     *  @OA\Parameter(description="ID of currency", in="path", name="currency", required=true,
     *      @OA\Schema(type="integer", format="int64", example="1")
     *  ),
     * summary="Show specific currencies",
     * operationId="getCurrency",
     * tags={"Currency"},
     * security={{ "apiAuth": {} }},
     * @OA\Response(response=200, description="Operation executed successfully", @OA\JsonContent()),
     * @OA\Response(response=400, description="Bad request", @OA\JsonContent()),
     * @OA\Response(response=404, description="Resource Not Found", @OA\JsonContent()),
     * )
     */
    public function show(string $id): Response
    {
        $currency = Currency::findOrFail($id);
        return $this->sendResponse($currency->load(self::relations));
    }


    /**
     * Update a resource.
     *
     * @param CurrencyRequest $request
     * @param string $id
     * @return Response
     *
     * @OA\Put(
     * path="/api/currency/{currency}",
     * @OA\Parameter(description="ID of currency", in="path", name="currency", required=true,
     *      @OA\Schema(type="integer", format="int64", example="1")
     *  ),
     * summary="Update a currency",
     * operationId="updateCurrency",
     * tags={"Currency"},
     * security={{ "apiAuth": {} }},
     * @OA\RequestBody(
     *    required=true,
     *    description="data to update a currency",
     *    @OA\JsonContent(
    @OA\Property(property="name", type="string", example="Example"),
     * @OA\Property(property="code", type="string", example="ex"),
     * @OA\Property(property="num", type="string", example="2"),
     * @OA\Property(property="symbol", type="char", example="ex"),
     * @OA\Property(property="symbol_native", type="char", example="e"),
     * @OA\Property(property="num_decimals", type="integer", example="2"),
     *    ),
     * ),
     * @OA\Response(response=200, description="Operation executed successfully", @OA\JsonContent()),
     * @OA\Response(response=400, description="Bad request", @OA\JsonContent()),
     * @OA\Response(response=422, description="Bad request", @OA\JsonContent()),
     * @OA\Response(response=404, description="Resource Not Found", @OA\JsonContent()),
     * )
     */
    public function update(CurrencyRequest $request, string $id): Response
    {
        $currency = Currency::findOrFail($id);
        $currency->update($request->all());
        return $this->sendResponse($currency->load(self::relations));
    }

    /**
     * Delete a resource.
     *
     * @param string $id
     * @return Response
     * @OA\Delete(
     * path="/api/currency/{currency}",
     *  @OA\Parameter(description="ID of currency", in="path", name="currency", required=true,
     *      @OA\Schema(type="integer", format="int64", example="1")
     *  ),
     * summary="Delete a currency",
     * operationId="deleteCurrency",
     * tags={"Currency"},
     * security={{ "apiAuth": {} }},
     * @OA\Response(response=200, description="Operation executed successfully", @OA\JsonContent()),
     * @OA\Response(response=204, description="Operation executed successfully", @OA\JsonContent()),
     * @OA\Response(response=400, description="Bad request", @OA\JsonContent()),
     * @OA\Response(response=404, description="Resource Not Found", @OA\JsonContent()),
     * )
     */
    public function destroy(string $id): Response
    {
        $currency = Currency::findOrFail($id);
        $currency->delete();
        return $this->sendResponse("ok", 204);
    }
}
