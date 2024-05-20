<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

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
        return auth()->user()->load(
            [
                'events.eventDates',
                'events.eventImages',
                'events.eventSubcategories',
            ]
        );
    }

    public function changePassword($data, $id)
    {
        $user = User::find($id);
        $oldPasswordHash = $user->password;

        if (Hash::check($data['password'], $oldPasswordHash)
            && $data['new_password'] == $data['new_password_confirm']
        ) {
            return $user->update([
                'password' => Hash::make(($data['new_password'])),
            ]);
        }

        return false;
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
