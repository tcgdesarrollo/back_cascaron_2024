<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use OpenApi\Annotations as OA;

class UserController extends Controller
{


    const detail_relations = [

    ];


    /**
     * @OA\Get(
     *     path="/api/user",
     *     tags={"User"},
     *     summary="List of users",
     *     description="Get list of all registered users",
     *     operationId="listUser",
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
        $query = User::with(self::detail_relations);
        return $this->sendResponsePaginate($query, $request);
    }


    /**
     * Store a newly created resource.
     *
     * @param UserRequest $request
     * @return Response
     *
     * @OA\Post(
     * path="/api/user",
     * summary="create a new user",
     * operationId="newuser",
     * tags={"User"},
     * security={{ "apiAuth": {} }},
     * @OA\RequestBody(
     *    required=true,
     *    description="data to create a new user",
     *    @OA\JsonContent(
    @OA\Property(property="name", type="string", example="Example"),
     *    ),
     * ),
     * @OA\Response(response=201, description="Created user", @OA\JsonContent()),
     * @OA\Response(response=400, description="Bad request", @OA\JsonContent()),
     * @OA\Response(response=422, description="Bad request", @OA\JsonContent()),
     * @OA\Response(response=404, description="Resource Not Found", @OA\JsonContent()),
     * )
     */
    public function store(UserRequest $request): Response
    {
        $password = Str::password(8);
        $request->merge([
            'password' => Hash::make($password),
            'email'=>Str::lower($request->email)
        ]);
        $user = User::create($request->all());
        $extra = [
            'password'=>$password,
            'name'=>$user->name
        ];
        (new QueueController())->store('created_user',[$user->email],$extra,true, language: $user->language);
        return $this->sendResponse($user->load(self::detail_relations), 201);
    }

    /**
     * Show specific resource.
     *
     * @param string $id
     * @return Response
     *
     * @OA\get(
     * path="/api/user/{user}",
     *  @OA\Parameter(description="ID of user", in="path", name="user", required=true,
     *      @OA\Schema(type="integer", format="int64", example="1")
     *  ),
     * summary="Show specific users",
     * operationId="getUser",
     * tags={"User"},
     * security={{ "apiAuth": {} }},
     * @OA\Response(response=200, description="Operation executed successfully", @OA\JsonContent()),
     * @OA\Response(response=400, description="Bad request", @OA\JsonContent()),
     * @OA\Response(response=404, description="Resource Not Found", @OA\JsonContent()),
     * )
     */
    public function show(string $id): Response
    {
        $user = User::with(self::detail_relations)->findOrFail($id);
        return $this->sendResponse($user);
    }


    /**
     * Update a resource.
     *
     * @param UserRequest $request
     * @param string $id
     * @return Response
     *
     * @OA\Put(
     * path="/api/user/{user}",
     * @OA\Parameter(description="ID of user", in="path", name="user", required=true,
     *      @OA\Schema(type="integer", format="int64", example="1")
     *  ),
     * summary="Update a user",
     * operationId="updateUser",
     * tags={"User"},
     * security={{ "apiAuth": {} }},
     * @OA\RequestBody(
     *    required=true,
     *    description="data to update a user",
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
    public function update(UserRequest $request, string $id): Response
    {
        $user = User::findOrFail($id);
        $user->update($request->all());
        return $this->sendResponse($user->fresh());
    }

    /**
     * Delete a resource.
     *
     * @param string $id
     * @return Response
     * @OA\Delete(
     * path="/api/user/{user}",
     *  @OA\Parameter(description="ID of user", in="path", name="user", required=true,
     *      @OA\Schema(type="integer", format="int64", example="1")
     *  ),
     * summary="Delete a user",
     * operationId="deleteUser",
     * tags={"User"},
     * security={{ "apiAuth": {} }},
     * @OA\Response(response=200, description="Operation executed successfully", @OA\JsonContent()),
     * @OA\Response(response=204, description="Operation executed successfully", @OA\JsonContent()),
     * @OA\Response(response=400, description="Bad request", @OA\JsonContent()),
     * @OA\Response(response=404, description="Resource Not Found", @OA\JsonContent()),
     * )
     */
    public function destroy(string $id): Response
    {
        $user = User::findOrFail($id);
        $user->delete();
        return $this->sendResponse("ok", 204);
    }
}
