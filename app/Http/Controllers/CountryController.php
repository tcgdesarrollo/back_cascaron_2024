<?php

namespace App\Http\Controllers;

use App\Http\Requests\CountryRequest;
use App\Models\Country;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use OpenApi\Annotations as OA;

class CountryController extends Controller
{
    const relations = [

    ];
    const detail_relations = [
        'locations:id,name,country_id',
        'subdivisions:id,name,country_id'
    ];

    /**
     * @OA\Get(
     *     path="/api/country",
     *     tags={"Country"},
     *     summary="List of countries",
     *     description="Get list of all registered countries",
     *     operationId="listCountries",
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
        $query = Country::query();
        return $this->sendResponsePaginate($query, $request);
    }


    /**
     * Store a newly created resource.
     *
     * @param CountryRequest $request
     * @return Response
     *
     * @OA\Post(
     * path="/api/country",
     * summary="create a new country",
     * operationId="newcountry",
     * tags={"Country"},
     * security={{ "apiAuth": {} }},
     * @OA\RequestBody(
     *    required=true,
     *    description="data to create a new country",
     *    @OA\JsonContent(
     *       @OA\Property(property="name", type="string", example="Country 1", description="Country Common Name"),
     *       @OA\Property(property="full_name", type="string", example="Country Full", description="Country Fullname"),
     *       @OA\Property(property="capital", type="string", example="Country Capital", description="Capital Common Name"),
     *       @OA\Property(property="code", type="string", example="CCCC", description="ISO3166-1-Alpha-2"),
     *       @OA\Property(property="code_alpha3", type="string", example="CCRRFF", description="ISO3166-1-Alpha-3"),
     *       @OA\Property(property="is_eu", type="boolean", example=0),
     *       @OA\Property(property="currency_code", type="string", example="AAA", description="iso_4217_code"),
     *       @OA\Property(property="currency_name", type="string", example="AAAA  BBBB", description="iso_4217_name"),
     *       @OA\Property(property="tld", type="string", example=".cm", description="Top level domain"),
     *       @OA\Property(property="callingcode", type="string", example="555", description="Calling prefix"),
     *    ),
     * ),
     * @OA\Response(response=200, description="response create new country", @OA\JsonContent()),
     * @OA\Response(response=400, description="Bad request", @OA\JsonContent()),
     * @OA\Response(response=404, description="Resource Not Found", @OA\JsonContent()),
     * )
     */
    public function store(CountryRequest $request)
    {
        $country = Country::create($request->all());
        return $this->sendResponse($country->load(self::relations), 201);
    }


    /**
     * Display the specified resource.
     *
     * @param string $id
     * @return Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
     *
     * @OA\get(
     * path="/api/country/{country_id}",
     *  @OA\Parameter(description="ID of country", in="path", name="country_id", required=true,
     *      @OA\Schema(type="integer", format="int64", example="1")
     *  ),
     * summary="get a country",
     * operationId="getCountry",
     * tags={"Country"},
     * security={{ "apiAuth": {} }},
     * @OA\Response(response=200, description="response show a country", @OA\JsonContent()),
     * @OA\Response(response=400, description="Bad request", @OA\JsonContent()),
     * @OA\Response(response=404, description="Resource Not Found", @OA\JsonContent()),
     * )
     */
    public function show(string $id): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        $country = Country::with(self::detail_relations)->findOrFail($id);
        return $this->sendResponse($country->load(self::relations));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     *
     *
     * @OA\Put(
     * path="/api/country/{country_id}",
     * @OA\Parameter(description="ID of country", in="path", name="country_id", required=true,
     *      @OA\Schema(type="integer", format="int64", example="1")
     *  ),
     * summary="update a country",
     * operationId="updateCountry",
     * tags={"Country"},
     * security={{ "apiAuth": {} }},
     * @OA\RequestBody(
     *    required=true,
     *    description="data to update a country",
     *    @OA\JsonContent(
     *       @OA\Property(property="name", type="string", example="Country 1", description="Country Common Name"),
     *       @OA\Property(property="full_name", type="string", example="Country Full", description="Country Fullname"),
     *       @OA\Property(property="capital", type="string", example="Country Capital", description="Capital Common Name"),
     *       @OA\Property(property="code", type="string", example="CCCC", description="ISO3166-1-Alpha-2"),
     *       @OA\Property(property="code_alpha3", type="string", example="CCRRFF", description="ISO3166-1-Alpha-3"),
     *       @OA\Property(property="is_eu", type="boolean", example=0),
     *       @OA\Property(property="currency_code", type="string", example="AAA", description="iso_4217_code"),
     *       @OA\Property(property="currency_name", type="string", example="AAAA  BBBB", description="iso_4217_name"),
     *       @OA\Property(property="tld", type="string", example=".cm", description="Top level domain"),
     *       @OA\Property(property="callingcode", type="string", example="555", description="Calling prefix"),
     *    ),
     * ),
     * @OA\Response(response=200, description="response updated country", @OA\JsonContent()),
     * @OA\Response(response=400, description="Bad request", @OA\JsonContent()),
     * @OA\Response(response=404, description="Resource Not Found", @OA\JsonContent()),
     * )
     */
    public function update(Request $request, string $id)
    {
        $country = Country::findOrFail($id);
        $country->update($request->all());
        return $this->sendResponse($country->load(self::relations));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $id
     * @return Response
     * @OA\Delete(
     * path="/api/country/{country_id}",
     *  @OA\Parameter(description="ID of country", in="path", name="country_id", required=true,
     *      @OA\Schema(type="integer", format="int64", example="1")
     *  ),
     * summary="delete a country",
     * operationId="deleteCountry",
     * tags={"Country"},
     * security={{ "apiAuth": {} }},
     * @OA\Response(response=204, description="response after delete country", @OA\JsonContent()),
     * @OA\Response(response=400, description="Bad request", @OA\JsonContent()),
     * @OA\Response(response=404, description="Resource Not Found", @OA\JsonContent()),
     * )
     */
    public function destroy(string $id)
    {
        $country = Country::findOrFail($id);
        $country->delete();
        return $this->sendResponse("ok", 204);
    }
}
