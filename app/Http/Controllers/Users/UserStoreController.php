<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\StoreUserRequest;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;

class UserStoreController extends Controller
{
    protected $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function __invoke(StoreUserRequest $request): JsonResponse
    {
        $data = $request->validated();

        $this->service->storeUser($data);

        return response()->json([
            'message' => 'User stored successfully',
        ]);
    }
}
