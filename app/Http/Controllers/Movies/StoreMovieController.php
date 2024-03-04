<?php

namespace App\Http\Controllers\Movies;

use App\Http\Controllers\Controller;
use App\Http\Requests\Movie\StoreMovieRequest;
use App\Services\MovieService;
use Illuminate\Http\JsonResponse;

class StoreMovieController extends Controller
{
    protected $service;

    public function __construct(MovieService $service)
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
