<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\ChangePasswordRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ChangePasswordController extends Controller
{
    protected $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function __invoke($id): JsonResponse
    {
        $response = $this->service->changePassword(request()->all(), $id);

        if (!$response) {
            return response()->json([
                'message' => 'Invalid credentials',
            ]);
        }

        return response()->json([
            'message' => 'Your password has been changed',
        ]);
    }
}
