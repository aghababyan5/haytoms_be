<?php

namespace App\Http\Controllers\Posts;

use App\Http\Controllers\Controller;
use App\Http\Requests\Movie\StoreMovieRequest;
use App\Services\PostService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UpdatePostController extends Controller
{
    protected $service;

    public function __construct(PostService $service)
    {
        $this->service = $service;
    }

    public function __invoke(StoreMovieRequest $request): JsonResponse
    {
        $this->service->store($request->validated());

        return response()->json([
            'message' => 'Data stored successfully',
        ]);
    }
}
