<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistrationRequest;
use App\Http\Resources\UserResource;
use App\Services\UsersService;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function __construct(
        private readonly UsersService $usersService,
    )
    {
    }

    public function registration(RegistrationRequest $request)
    {
        return new UserResource($this->usersService->create($request->getDto()));
    }

    /**
     * @param  LoginRequest  $request
     * @return JsonResponse|UserResource
     */
    public function login(LoginRequest $request): JsonResponse|UserResource
    {
        $credentials = $request->all();

        $token = auth()->attempt($credentials);

        if (!$token) {
            return response()->json(['error' => 'Credentials not match our records'], 422);
        }

        return $this->respondWithToken($token);
    }

    /**
     * @return JsonResponse
     */
    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'User successfully signed out']);
    }

    /**
     * @return UserResource
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * @return UserResource
     */
    public function me()
    {
        return (new UserResource(auth()->user()));
    }

    /**
     * @param  string  $token
     *
     * @return UserResource
     */
    protected function respondWithToken(string $token)
    {
        return (new UserResource(auth()->user()))->additional(
            [
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60,
            ]
        );
    }
}
