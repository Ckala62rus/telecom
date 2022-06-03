<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\AuthLoginRequest;
use App\Http\Requests\Auth\AuthRegisterRequest;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use function GuzzleHttp\Promise\all;

class AuthController extends BaseController
{
    /**
     * Registration user
     * @param AuthRegisterRequest $request
     * @return JsonResponse
     */
    public function register(AuthRegisterRequest $request)
    {
        $data = $request->all();

        $user = User::create($data);

        $token = $user
            ->createToken('auth_token')
            ->plainTextToken;

        return $this->sendResponse([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], "Authentication success");
    }

    /**
     * Authentication user by email and password
     * @param AuthLoginRequest $request
     * @return JsonResponse
     */
    public function login(AuthLoginRequest $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid login details'
            ], 401);
        }

        $user = User::where('email', $request['email'])
            ->firstOrFail();

        $token = $user
            ->createToken('auth_token')
            ->plainTextToken;

        return $this->sendResponse([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], "Authentication success");
    }

    /**
     * Get current model auth user
     * @param Request $request
     * @return mixed
     */
    public function me(Request $request): JsonResponse
    {
        return $this->sendResponse([
            'user' => UserResource::make($request->user())
        ], "curent auth user");
    }
}
