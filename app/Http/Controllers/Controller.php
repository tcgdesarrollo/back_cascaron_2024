<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
use OpenApi\Annotations as OA;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * @OA\Info(
     *    title="Documentation APIRest for masterdata",
     *    description="Internal lists of endpoints to connect with masterdata",
     *    version="0.1",
     *    @OA\Contact(
     *          url="https://thecloud.group"
     *      ),
     * )
     *
     * @OA\SecurityScheme(
     *     type="http",
     *     description="Login with email and password to get the authentication token",
     *     name="Token based Based",
     *     in="header",
     *     scheme="bearer",
     *     bearerFormat="JWT",
     *     securityScheme="apiAuth",
     * )
     */

    public function sendResponse($result, $state = 200): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        return response(['data' => $result], $state);
    }


    public function sendResponsePaginate($query, $request, $state = 200): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        $page = $request->page ?? 1;
        $total = $request->total ?? 20;
        $needle = $request->search ?? null;
        return response(['data' => $query->paginate($total, page: $page)], $state);
    }
}
