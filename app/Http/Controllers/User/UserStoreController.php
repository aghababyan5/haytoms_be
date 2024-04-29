<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\StoreUserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
