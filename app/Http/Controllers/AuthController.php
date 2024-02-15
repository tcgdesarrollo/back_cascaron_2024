<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use OpenApi\Annotations as OA;

class AuthController extends Controller
{
    /**
     * Get a JWT via given credentials. Authentication
     *
     *
     * @OA\Post(
     * path="/api/auth/login",
     * summary="Sign in",
     * description="Login by email, password",
     * operationId="authLogin",
     * tags={"Auth"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"email","password"},
     *       @OA\Property(property="email", type="string", format="email", example="admin@demo.com"),
     *       @OA\Property(property="password", type="string", format="password", example="demo"),
     *    ),
     * ),
     * @OA\Response(
     *    response=422,
     *    description="Wrong credentials response",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Sorry, wrong email address or password. Please try again")
     *        )
     *     )
     * )
     *
     * @return Application|ResponseFactory|\Illuminate\Foundation\Application|Response
     * @throws ValidationException
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:3'
        ], [
            'email.required' => 'Debe especificar un email',
            'password.required' => 'Debe especificar una clave',
            'email.exists' => 'El usuario no existe'
        ]);
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return $this->sendResponse($user->createToken('web')->plainTextToken);
    }


   /**
     * Get the authenticated User.
     *
     *  @OA\Get(
     *  path="/api/auth/me",
     *  summary="user info login",
     *  operationId="authMe",
     *  tags={"Auth"},
     *  @OA\Response(response=200, description="", @OA\JsonContent()),
     *  security={{ "apiAuth": {} }}
     * )
     * @return JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        $user = auth()->user();
        $user->tokens()->delete();

        return response()->json(['message' => 'Successfully logged out']);
    }
}
