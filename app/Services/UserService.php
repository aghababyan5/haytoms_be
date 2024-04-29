<?php

namespace App\Services;

use App\Models\User;

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
}
