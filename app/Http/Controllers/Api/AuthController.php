<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginUserRequest;
use App\Models\User;
use App\Traits\ApiResponses;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    use ApiResponses;
    public function login(LoginUserRequest $request): JsonResponse
    {
        $request->validated($request->all());

        if (!auth()->attempt($request->only('email', 'password'))) {
            return $this->error('Invalid credentials', 401);
        }

        $user = User::firstWhere('email', $request->email);

        return $this->ok(
            'Authenticated',
            [
                'token' => $user->createToken('auth_token'. $user->email)->plainTextToken,
            ]
        );
    }

    public function register()
    {
        return $this->ok('register');
    }
}
