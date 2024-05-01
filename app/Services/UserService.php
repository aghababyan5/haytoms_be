<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;

class UserService
{
    public function storeUser($data): void
    {
        User::create([
            'name'         => $data['name'],
            'surname'      => $data['surname'],
            'email'        => $data['username'],
            'phone_number' => $data['phone_number'],
            'password'     => $data['password'],
            'role'         => $data['role'],
        ]);
    }

    public function getAuthUser(): ?Authenticatable
    {
        return auth()->user()->load('events');
    }

    protected function respondWithToken($token): JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth()->factory()->getTTL() * 60,
            'user'         => auth()->user(),
        ]);
    }

    public function refresh(): JsonResponse
    {
        return $this->respondWithToken(auth()->refresh());
    }
}
